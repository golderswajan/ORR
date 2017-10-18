<?php
	/**
	*  Result CRUD
	*/
	require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/connect.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/session.php');
	
	class DALResult
	{
		
		function __construct()
		{

			
		}
		public function getResult($registeredTermId)
		{
			global $con;
			$sql = "SELECT course.prefix,course.courseNo,course.courseTitle,course.credit,mark.totalMark,registeredcourse.isRetakeCourse as remarks FROM course,registeredcourse,mark,offeredcourse WHERE course.id = offeredcourse.courseId && offeredcourse.id = registeredcourse.offeredCourseId &&registeredcourse.id = mark.registeredCourseId && registeredcourse.registeredTermId = $registeredTermId";
			$result = mysqli_query($con,$sql);

			return $result;
		}

		public function getRegisteredTerms($studentId,$varsityDeptId)
		{
			global $con;
			$sql = "SELECT registeredterm.id as registeredTermId,degree.name as degreeName,session.sessionName,year.year,term.term FROM registeredterm,offeredterm,degree,session,year,term WHERE registeredterm.studentId = $studentId && registeredterm.registrationCompleted = 1 && registeredterm.offeredTermId = offeredterm.id && offeredterm.degreeId = degree.id && offeredterm.sessionId = session.id && offeredterm.yearId = year.id && offeredterm.termId = term.id && offeredterm.varsityDeptId = $varsityDeptId";
			$result = mysqli_query($con,$sql);

			return $result;
		}

		public function getById($id)
		{
			global $con;
			$sql = "SELECT * FROM registeredterm WHERE id=".$id;
			$result = mysqli_query($con,$sql);

			return $result;
		}

	
		
		// Calcualte and return each registrered term credit.
		public function getCreditRegistered($registeredTermId)
		{
			global $con;
			$sql = "SELECT SUM(course.credit) as registeredCredit FROM course,offeredcourse,registeredterm,registeredcourse WHERE course.id = offeredcourse.courseId && offeredcourse.id = registeredcourse.offeredCourseId && registeredcourse.registeredTermId = registeredterm.id AND registeredterm.id = $registeredTermId";
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

		// Calcualte and return each registrered term credit.
		public function getCreditEarned($registeredTermId)
		{
			global $con;
			$sql = "SELECT SUM(course.credit) as registeredCredit FROM course,offeredcourse,registeredterm,registeredcourse,mark WHERE course.id = offeredcourse.courseId && offeredcourse.id = registeredcourse.offeredCourseId && registeredcourse.id = mark.registeredCourseId && mark.totalMark>=40 && registeredcourse.registeredTermId = registeredterm.id AND registeredterm.id = $registeredTermId";
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
		public function registeredTermId2yearTermId($registeredTermId)
		{
			global $con;

			$sql = "SELECT year.year, term.term FROM year,term,offeredterm,registeredterm WHERE year.id = offeredterm.yearId && term.id = offeredterm.termId AND offeredterm.id = registeredterm.offeredTermId && registeredterm.id = $registeredTermId";
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
		public function getHeaderInfo($studentId,$varsityDeptId,$registeredTermId)
		{
			global $con;
			$sql = "SELECT varsity.name as varsityName,dept.name as deptName,session.sessionName,year.year,term.term,user.fullName FROM user,student,varsitydept,varsity,dept,registeredterm,offeredterm,session,year,term WHERE user.id = student.userId && registeredterm.studentId = student.studentId && registeredterm.offeredTermId = offeredterm.id && offeredterm.sessionId = session.id && offeredterm.yearId = year.id && offeredterm.termId = term.id && offeredterm.varsityDeptId = varsitydept.id && varsitydept.varsityId = varsity.id && varsitydept.deptId = dept.id && varsitydept.id = $varsityDeptId && student.studentId = $studentId && registeredterm.id = $registeredTermId";
			$result = mysqli_query($con,$sql);
			if($result)
			{
				return $result;
			}
			else
			{
				return false;
			}

		}

	}


?>