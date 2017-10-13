<?php
	/**
	*  Courseregistration CRUD
	*/
	require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/connect.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/session.php');
	
	class DALCourseRegistrationApproval
	{
		
		function __construct()
		{

			
		}

		// Return all the sessions registerd
		public function getSessions($varsityDeptId)
		{
			global $con;
			$sql = "SELECT DISTINCT(session.id) as sessionId,session.sessionName FROM session,offeredterm WHERE session.id = offeredterm.sessionId && offeredterm.varsityDeptId = $varsityDeptId ORDER BY session.sessionName DESC";
			$result = mysqli_query($con,$sql);

			return $result;
		}

		// Return all the offeredTerm.sessionId that are running in that session
		public function getDegrees($varsityDeptId,$sessionId)
		{
			global $con;
			$sql = "SELECT DISTINCT(degree.id) AS degreeId,degree.name as degreeName FROM offeredterm,degree WHERE offeredterm.degreeId = degree.id && offeredterm.varsityDeptId = $varsityDeptId && offeredterm.sessionId = $sessionId ORDER BY degree.name ASC";
			$result = mysqli_query($con,$sql);

			return $result;
		}

		// Return all the offeredTerm.yearId that are running in that session
		public function getYears($varsityDeptId,$sessionId,$degreeId)
		{
			global $con;
			$sql = "SELECT offeredterm.yearId,year.year as yearName FROM offeredterm,year WHERE offeredterm.yearId = year.id && offeredterm.sessionId = $sessionId && offeredterm.degreeId = $degreeId && offeredterm.varsityDeptId = $varsityDeptId ORDER BY year.year ASC";
			$result = mysqli_query($con,$sql);

			return $result;
		}

		// Return all the offeredTerm.termId that are running in that session
		public function getTerms($varsityDeptId,$sessionId,$degreeId,$yearId)
		{
			global $con;
			$sql = "SELECT term.id as termId,term.term AS termName FROM offeredterm,term WHERE offeredterm.termId = term.id && offeredterm.varsityDeptId = $varsityDeptId && offeredterm.degreeId = $degreeId && offeredterm.sessionId = $sessionId && offeredterm.yearId = $yearId ORDER BY term.term ASC";
			$result = mysqli_query($con,$sql);

			return $result;
		}

		// Return all the students and their courses that are pending for approval 
		// and termRegistration is not completed i.e. no one approved yet.
		public function getRegisteredStudents($sessionSelected,$degreeSelected,$yearSelected,$termSelected,$varsityDeptId)
		{
			global $con;
			$sql = "SELECT student.studentId,user.fullName,registeredterm.id as registeredTermId FROM user,student,varsitydept,offeredterm,registeredterm WHERE user.id = student.userId && student.studentId = registeredterm.studentId && student.varsityDeptId = varsitydept.id && varsitydept.id = offeredterm.varsityDeptId && offeredterm.id = registeredterm.offeredTermId && registeredterm.registrationCompleted=0 && offeredterm.degreeId = $degreeSelected && offeredterm.sessionId = $sessionSelected && offeredterm.yearId = $yearSelected && offeredterm.termId = $termSelected && offeredterm.varsityDeptId = $varsityDeptId";
			$result = mysqli_query($con,$sql);

			return $result;
		}

		public function getRegisteredCourses($registeredTermId)
		{
			global $con;
			$sql = "SELECT registeredcourse.id as registeredCourseId,course.prefix,course.courseNo,course.courseTitle,course.credit FROM registeredcourse,offeredcourse,course WHERE registeredcourse.offeredCourseId = offeredcourse.id && offeredcourse.courseId = course.id &&  registeredcourse.registeredTermId = $registeredTermId && registeredcourse.approvedbyhead=0";
			$result = mysqli_query($con,$sql);

			return $result;
		}

		public function approveRegistration($field,$registeredTermId)
		{
			global $con;
			$sql = "UPDATE registeredcourse SET $field = 1 WHERE registeredcourse.registeredTermId = $registeredTermId";
			$result = mysqli_query($con,$sql);

			// And lock the term
			$this->registrationCompleted($registeredTermId);
			return $result;
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

		public function removeCourseRegistration($registeredCourseId)
		{
			global $con;
			$sql = "DELETE FROM registeredcourse WHERE registeredcourse.id = $registeredCourseId";
			$result = mysqli_query($con,$sql);

			return $result;
		}

		

		

	}


?>