<?php
	/**
	*  Courseregistration CRUD
	*/
	require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/connect.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/session.php');
	
	class DALCourseRegistration
	{
		
		function __construct()
		{

			
		}

		// Return all the terms registerd yet.
		// No need to consider versityDept
		// versityDept should be considered only insertion time
		public function getRegisteredTerms($studentId)
		{
			global $con;
			$sql = "SELECT registeredterm.id as registeredTermId FROM registeredterm,student WHERE registeredterm.studentId = student.studentId && student.studentId = $studentId";
			$result = mysqli_query($con,$sql);

			return $result;
		}
		// Return all the terms registerd yet.
		public function getCurrentRegisteredTerm($studentId)
		{
			global $con;
			$sql = "SELECT registeredterm.id as currentRegisteredTermId FROM registeredterm WHERE registeredterm.studentId  = $studentId ORDER BY id DESC LIMIT 1";
			$result = mysqli_query($con,$sql);

			return $result;
		}
		// Already registered in a term courses
		public function getRegisteredCourse($studentId,$registeredTermId)
		{
			global $con;
			$sql = "SELECT course.*,registeredcourse.id as registeredCourseId,year.year as year, term.term as term FROM course,year,term,offeredcourse,registeredterm,registeredcourse WHERE course.yearId = year.id && course.termId = term.id && course.id = offeredcourse.courseId && offeredcourse.id = registeredcourse.offeredCourseId && registeredcourse.approvedByHead = 1 && registeredcourse.approvedByCoursecoordinator = 1 && registeredcourse.registeredTermId = registeredterm.id && registeredterm.id = $registeredTermId && registeredterm.studentId = $studentId";
			$result = mysqli_query($con,$sql);

			return $result;
		}
	
		// Registered courses info by id
		public function getById($id)
		{
			global $con;
			$sql = "SELECT * FROM registeredcourse WHERE id=".$id;
			$result = mysqli_query($con,$sql);

			return $result;
		}

		// Select the courses to be registered
		public function getOfferedCourses($studentId)
		{
			global $con;
			// NB: varsityDept already fixed during term registration. 
			// Go ahed with registered term.

			// Select all the Offered course if,
			// 1. Student already not registered
			// 2. VarsityDeptId same to student varistyDeptId
			// 3. Current registeredterm and courses term are same
			// 4.  + Retake courses
			// 5. Prerequisite already passed if has prerequisite
			// 6. Term is running and not locked
			// 7. Mark table contain more than one registeredCourseId Handled it
			// 8. No courses already registered in current term (not applied)
			// Query explained in greatQuery.sql
			$sql = "SELECT course.*,offeredcourse.id as offeredCourseId,registeredterm.id as registeredTermId FROM course,offeredterm,offeredcourse,registeredterm,student WHERE course.varsityDeptId= offeredterm.varsityDeptId && course.yearId = offeredterm.yearId && course.termId = offeredterm.termId && course.degreeId = offeredterm.degreeId && offeredterm.status = 1 && offeredterm.isLocked = 0 && offeredterm.id = offeredcourse.offeredTermId && course.id = offeredcourse.courseId && offeredterm.id = registeredterm.offeredTermId && registeredterm.registrationCompleted = 0 && registeredterm.studentId = student.studentId && student.studentId = $studentId &&(course.prerequisite is NULL || course.prerequisite IN( SELECT course.id FROM course,offeredcourse,registeredcourse,registeredterm WHERE course.id = offeredcourse.courseId && offeredcourse.id = registeredcourse.offeredCourseId && registeredcourse.registeredTermId = registeredterm.id && registeredterm.studentId = student.studentId && student.studentId = $studentId)) UNION SELECT course.*,offeredcourse.id as offeredCourseId,registeredterm.id as registeredTermId FROM course,offeredcourse,registeredcourse,mark,student,registeredterm WHERE course.id= offeredcourse.courseId && offeredcourse.id = registeredcourse.offeredCourseId && registeredcourse.id = mark.registeredCourseId && mark.mark <40 && registeredcourse.registeredTermId = registeredterm.id && registeredterm.registrationCompleted = 0 && registeredterm.studentId = $studentId";
			$result = mysqli_query($con,$sql);

			return $result;
		}

		// Entry courses registration
		public function insert($sql)
		{
			global $con;
			$result = mysqli_query($con,$sql);
			if($result)
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		// Completed course registration and block this term
		public function registrationCompleted($registeredTermId)
		{
			global $con;
			$sql = "UPDATE registeredterm SET registrationCompleted = 1 WHERE registeredterm.id = $registeredTermId";
			$result = mysqli_query($con,$sql);
			if($result)
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		// Calcualte and return each registrered term credit.
		public function getCreditRegistered($registeredTermId)
		{
			global $con;
			$sql = "SELECT SUM(course.credit) as registeredCredit FROM course,offeredcourse,registeredcourse,registeredcourse WHERE course.id = offeredcourse.courseId && offeredcourse.id = registeredcourse.offeredCourseId && registeredcourse.registeredTermId = registeredcourse.id AND registeredcourse.id = $registeredTermId";
			$result = mysqli_query($con,$sql);
			if($result)
			{
				return $result;
			}
			else
			{
				return 0;
			}
		}

		// Calcualte and return each registrered course earned credit
		public function getCreditEarned($registeredCourseId)
		{
			global $con;

			// When marks are greater than 40 count as passed
			// And add the course credit to earned credit.
			$sql = "SELECT SUM(course.credit) as earnedCredit FROM course,offeredcourse,registeredcourse,mark WHERE course.id = offeredcourse.courseId && offeredcourse.id = registeredcourse.offeredCourseId && registeredcourse.id = mark.registeredCourseId && mark.mark>=40 && registeredcourse.id = $registeredCourseId";
			$result = mysqli_query($con,$sql);
			if($result)
			{
				return $result;
			}
			else
			{
				return 0;
			}
		}

		// Get year and term by registered term id
		public function registeredCourseId2yearTermId($registeredCourseId)
		{
			global $con;

			$sql = "SELECT year.year, term.term FROM year,term,course,offeredcourse,registeredcourse WHERE course.yearId = year.id && course.termId = term.id && course.id = offeredcourse.courseId && registeredcourse.offeredCourseId = offeredcourse.id && registeredcourse.id = $registeredCourseId";
			$result = mysqli_query($con,$sql);
			if($result)
			{
				return $result;
			}
			else
			{
				return 0;
			}
		}

	}


?>