<?php
	/**
	*  Courseregistration CRUD
	*/
	require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/connect.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/session.php');
	
	class DALPaymentRate
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
		public function loadPaymentRate($sessionId,$degreeId,$yearId,$termId,$varsityDeptId)
		{
			global $con;
			$sql = "SELECT paymentrate.* FROM paymentrate,offeredterm WHERE paymentrate.offeredtermId = offeredterm.id && offeredterm.varsityDeptId = $varsityDeptId && offeredterm.degreeId = $degreeId && offeredterm.sessionId = $sessionId && offeredterm.yearId  = $yearId && offeredterm.termId = $termId ORDER BY paymentrate.id DESC";
			$result = mysqli_query($con,$sql);

			return $result;
		}

		public function insert($sessionId,$degreeId,$yearId,$termId,$varsityDeptId,$fieldName,$amount)
		{
			global $con;
			$sql = "INSERT INTO `paymentrate`(`id`, `fieldName`, `amount`, `offeredtermId`) VALUES ('','$fieldName',$amount,(SELECT offeredterm.id FROM offeredterm WHERE offeredterm.varsityDeptId = $varsityDeptId && offeredterm.degreeId = $degreeId && offeredterm.sessionId = $sessionId && offeredterm.yearId = $yearId && offeredterm.termId  = $termId))";
			$result = mysqli_query($con,$sql);

			return $result;
		}

	}


?>