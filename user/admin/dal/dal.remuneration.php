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
		
		public function getRemunerationReport($sessionId,$degreeId,$yearId,$termId,$varsityDeptId)
		{
			global $con;
			$sql = "SELECT COUNT(registeredcourse.id) as noScripts,user.fullName,course.prefix,course.courseNo FROM registeredcourse,offeredcourse,course,registeredterm,offeredterm,offeredteacher,teacher,user WHERE registeredcourse.offeredCourseId = offeredcourse.id && offeredcourse.courseId = course.id && offeredcourse.offeredTermId = offeredterm.id && offeredteacher.offeredCourseId = offeredcourse.id && offeredteacher.teacherId = teacher.id && teacher.userId = user.id && offeredterm.degreeId = $degreeId && offeredterm.sessionId = $sessionId && offeredterm.yearId = $yearId && offeredterm.termId = $termId && offeredterm.varsityDeptId = $varsityDeptId GROUP BY user.id";
			$result = mysqli_query($con,$sql);

			return $result;
		}

	}


?>