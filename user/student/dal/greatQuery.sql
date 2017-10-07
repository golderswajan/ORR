-- Finding eligible courses.

-- Selection line
SELECT course.*,offeredcourse.id as offeredCourseId,registeredterm.id as registeredTermId

-- Tables related to
FROM course,offeredterm,offeredcourse,registeredterm,student

-- Conditions
WHERE 

-- course->offeredterm
course.varsityDeptId= offeredterm.varsityDeptId && course.yearId = offeredterm.yearId && course.termId = offeredterm.termId && course.degreeId = offeredterm.degreeId 

-- Offeredterm Self Conditions
&& offeredterm.status = 1 && offeredterm.isLocked = 0

-- Offeredterm -> offeredcourse, course->offeredcourse (courses offered under that term)
&& offeredterm.id = offeredcourse.offeredTermId && course.id = offeredcourse.courseId

-- Offeredterm -> registeredterm (which term is registered?)
&& offeredterm.id = registeredterm.offeredTermId

-- Course registration is incompleted 
-- i.e. registeredterm.registrationCompleted ==0
&& registeredterm.registrationCompleted = 0

-- Registeredterm owner student (replace 150206 to dinamically handle in php)
&& registeredterm.studentId = student.studentId && student.studentId = 150206

-- These are for finding new courses that are eligible to regisrer under registered term
-- now extra informations...
-- Check if prerequisite are already passed or prerequisite is null.. Liked to previous conditions by AND
-- Alert: never use '='' operator to check null 
&& (course.prerequisite is NULL  || course.prerequisite IN(
SELECT course.id 
FROM course,offeredcourse,registeredcourse,registeredterm

-- course->offerredcourse->registeredcourse->registeredterm->student->studentId
WHERE course.id = offeredcourse.courseId && offeredcourse.id = registeredcourse.offeredCourseId && registeredcourse.registeredTermId = registeredterm.id && registeredterm.studentId = student.studentId && student.studentId = 150206
))

-- Add Retake courses to this course list.
-- Skip the term i.e. previous term is not currently allowed
-- + That secific
UNION

SELECT course.*,offeredcourse.id as offeredCourseId,registeredterm.id as registeredTermId
FROM course,offeredcourse,registeredcourse,mark,student,registeredterm
WHERE 
-- course->offeredcourse->registeredcourse->mark->fail/pass
-- mark is not thesis mark 'x'
course.id= offeredcourse.courseId && offeredcourse.id = registeredcourse.offeredCourseId && registeredcourse.id = mark.registeredCourseId && mark.mark <40 && mark !='x'
-- registeredcourse->registeredterm->student->studentId
&& registeredcourse.registeredTermId = registeredterm.id && registeredterm.studentId = student.studentId && student.studentId = 150206

-- And prerequisite is not thesis

-- Course registration is incompleted 
-- i.e. registeredterm.registrationCompleted ==0
&& registeredterm.registrationCompleted = 0