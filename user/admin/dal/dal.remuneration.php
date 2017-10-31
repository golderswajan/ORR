<?php
	/**
	*  Courseregistration CRUD
	*/
	require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/connect.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/session.php');
	
	class DALRemuneration
	{
		
		function __construct()
		{

			
		}

		// Return all the sessions registerd
		public function getSessions($varsityDeptId)
		{
			global $con;
			$sql = "SELECT DISTINCT(session.id) as sessionId,session.sessionName FROM session,offeredterm WHERE session.id = offeredterm.sessionId && offeredterm.varsityDeptId = $varsityDeptId ORDER BY sessionName DESC";
			$result = mysqli_query($con,$sql);

			return $result;
		}

		// Return all the offeredTerm.sessionId that are running in that session
		public function getDegrees($varsityDeptId,$sessionId)
		{
			global $con;
			$sql = "SELECT DISTINCT(degree.id) AS degreeId,degree.name as degreeName FROM offeredterm,degree WHERE offeredterm.degreeId = degree.id && offeredterm.varsityDeptId = $varsityDeptId && offeredterm.sessionId = $sessionId";
			$result = mysqli_query($con,$sql);

			return $result;
		}

		// Return all the offeredTerm.yearId that are running in that session
		public function getYears($varsityDeptId,$sessionId,$degreeId)
		{
			global $con;
			$sql = "SELECT offeredterm.yearId,year.year as yearName FROM offeredterm,year WHERE offeredterm.yearId = year.id && offeredterm.sessionId = $sessionId && offeredterm.degreeId = $degreeId && offeredterm.varsityDeptId = $varsityDeptId ORDER BY year ASC";
			$result = mysqli_query($con,$sql);

			return $result;
		}

		// Return all the offeredTerm.termId that are running in that session
		public function getTerms($varsityDeptId,$sessionId,$degreeId,$yearId)
		{
			global $con;
			$sql = "SELECT term.id as termId,term.term AS termName FROM offeredterm,term WHERE offeredterm.termId = term.id && offeredterm.varsityDeptId = $varsityDeptId && offeredterm.degreeId = $degreeId && offeredterm.sessionId = $sessionId && offeredterm.yearId = $yearId ORDER BY term ASC";
			$result = mysqli_query($con,$sql);

			return $result;
		}

		public function getOfferedCourses($sessionId,$degreeId,$yearId,$termId,$varsityDeptId)
		{
			global $con;
			$sql = "SELECT offeredcourse.id as offeredCourseId, course.prefix,course.courseNo,course.courseTitle,course.credit FROM offeredcourse,course,offeredterm WHERE course.id = offeredcourse.courseId && offeredcourse.offeredTermId = offeredterm.id && offeredterm.degreeId = $degreeId && offeredterm.sessionId = $sessionId && offeredterm.yearId = $yearId && offeredterm.termId =$termId && offeredterm.varsityDeptId = $varsityDeptId";
			$result = mysqli_query($con,$sql);

			return $result;
		}

		public function getRegisteredCourses($sessionId,$degreeId,$yearId,$termId,$varsityDeptId)
		{
			global $con;
			$sql = "SELECT student.studentId,registeredcourse.id as registeredCourseId FROM student,offeredterm,registeredterm,registeredcourse WHERE student.studentId = registeredterm.studentId && registeredcourse.registeredTermId = registeredterm.id && registeredcourse.offeredCourseId = offeredcourse.id && registeredterm.offeredTermId = offeredterm.id && offeredterm.degreeId = $degreeId && offeredterm.sessionId = $sessionId &&  offeredterm.yearId = $yearId && offeredterm.termId = $termId && offeredterm.varsityDeptId = $varsityDeptId ";
			$result = mysqli_query($con,$sql);

			return $result;
		}
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
# Remunaration reports 
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
		public function getTheoryCourses($sessionId,$degreeId,$yearId,$termId,$varsityDeptId)
		{
			global $con;
			$sql = "SELECT COUNT(registeredcourse.id) as noScripts,user.fullName,course.prefix,course.courseNo FROM mark,marksection,section,registeredcourse,offeredcourse,course,offeredterm,offeredteacher,teacher,user WHERE section.id = marksection.sectionId && mark.id = marksection.markId && mark.registeredCourseId = registeredcourse.id && section.type = 'Theory' && section.name = 'Section A' && registeredcourse.offeredCourseId = offeredcourse.id && offeredcourse.courseId = course.id && offeredcourse.offeredTermId = offeredterm.id && offeredteacher.offeredCourseId = offeredcourse.id && offeredteacher.teacherId = teacher.id && teacher.userId = user.id && offeredterm.degreeId = $degreeId && offeredterm.sessionId = $sessionId && offeredterm.yearId = $yearId && offeredterm.termId = $termId && offeredterm.varsityDeptId = $varsityDeptId GROUP BY course.id,user.id";
			$result = mysqli_query($con,$sql);

			return $result;
		}

		public function getSessionalCourses($sessionId,$degreeId,$yearId,$termId,$varsityDeptId)
		{
			global $con;
			$sql = "SELECT COUNT(registeredcourse.id) as noScripts,user.fullName,course.prefix,course.courseNo FROM mark,marksection,section,registeredcourse,offeredcourse,course,offeredterm,offeredteacher,teacher,user WHERE section.id = marksection.sectionId && mark.id = marksection.markId && mark.registeredCourseId = registeredcourse.id && section.type = 'Sessional' && (section.name = 'Viva' || section.name = 'Project') && registeredcourse.offeredCourseId = offeredcourse.id && offeredcourse.courseId = course.id && offeredcourse.offeredTermId = offeredterm.id && offeredteacher.offeredCourseId = offeredcourse.id && offeredteacher.teacherId = teacher.id && teacher.userId = user.id && offeredterm.degreeId = $degreeId && offeredterm.sessionId = $sessionId && offeredterm.yearId = $yearId && offeredterm.termId = $termId && offeredterm.varsityDeptId = $varsityDeptId GROUP BY course.id,user.id";
			$result = mysqli_query($con,$sql);

			return $result;
		}
		public function getClassTests($sessionId,$degreeId,$yearId,$termId,$varsityDeptId)
		{
			global $con;
			$sql = "SELECT COUNT(registeredcourse.id) as noScripts,user.fullName,course.prefix,course.courseNo FROM mark,marksection,section,registeredcourse,offeredcourse,course,offeredterm,offeredteacher,teacher,user WHERE section.id = marksection.sectionId && mark.id = marksection.markId && mark.registeredCourseId = registeredcourse.id && section.name = 'Continuous Assessment' && registeredcourse.offeredCourseId = offeredcourse.id && offeredcourse.courseId = course.id && offeredcourse.offeredTermId = offeredterm.id && offeredteacher.offeredCourseId = offeredcourse.id && offeredteacher.teacherId = teacher.id && teacher.userId = user.id && offeredterm.degreeId = $degreeId && offeredterm.sessionId = $sessionId && offeredterm.yearId = $yearId && offeredterm.termId = $termId && offeredterm.varsityDeptId = $varsityDeptId GROUP BY course.id,user.id";
			$result = mysqli_query($con,$sql);

			return $result;
		}
		public function getModarationCommittee($sessionId,$degreeId,$yearId,$termId,$varsityDeptId)
		{
			global $con;
			$sql = "SELECT * FROM modarationcommittee,offeredterm WHERE modarationcommittee.offeredTermId = offeredterm.id && offeredterm.degreeId = $degreeId && offeredterm.sessionId = $sessionId && offeredterm.yearId = $yearId && offeredterm.termId = $termId && offeredterm.varsityDeptId = $varsityDeptId";
			$result = mysqli_query($con,$sql);

			return $result;
		}
		public function getAnswerPaperScrutiny($sessionId,$degreeId,$yearId,$termId,$varsityDeptId)
		{
			global $con;
			$sql = "SELECT COUNT(registeredcourse.id) as noScripts,user.fullName FROM mark,marksection,section,registeredcourse,offeredcourse,course,offeredterm,tabulator,user WHERE section.id = marksection.sectionId && mark.id = marksection.markId && mark.registeredCourseId = registeredcourse.id  && registeredcourse.offeredCourseId = offeredcourse.id && offeredcourse.courseId = course.id && offeredcourse.offeredTermId = offeredterm.id && tabulator.offeredTermId = offeredterm.id && tabulator.userId = user.id && offeredterm.degreeId = $degreeId && offeredterm.sessionId = $sessionId && offeredterm.yearId = $yearId && offeredterm.termId = $termId && offeredterm.varsityDeptId = $varsityDeptId  GROUP BY tabulator.id";
			$result = mysqli_query($con,$sql);

			return $result;
		}

		public function getTabulationStudents($sessionId,$degreeId,$yearId,$termId,$varsityDeptId)
		{
			global $con;
			$sql = "SELECT COUNT(registeredterm.id) as noStudents,user.fullName FROM registeredterm,offeredterm,tabulator,user WHERE registeredterm.offeredTermId = offeredterm.id && tabulator.offeredTermId = offeredterm.id && tabulator.userId = user.id && offeredterm.degreeId = $degreeId && offeredterm.sessionId = $sessionId && offeredterm.yearId = $yearId && offeredterm.termId = $termId && offeredterm.varsityDeptId = $varsityDeptId  GROUP BY tabulator.id";
			$result = mysqli_query($con,$sql);

			return $result;
		}

		public function getTabulationCourses($sessionId,$degreeId,$yearId,$termId,$varsityDeptId)
		{
			global $con;
			$sql = "SELECT COUNT(offeredcourse.id) as noCourses,user.fullName FROM offeredcourse,offeredterm,tabulator,user WHERE offeredcourse.offeredTermId = offeredterm.id && tabulator.offeredTermId = offeredterm.id && tabulator.userId = user.id &&  offeredterm.degreeId = $degreeId && offeredterm.sessionId = $sessionId && offeredterm.yearId = $yearId && offeredterm.termId = $termId && offeredterm.varsityDeptId = $varsityDeptId  GROUP BY tabulator.id";
			$result = mysqli_query($con,$sql);

			return $result;
		}



	}


?>