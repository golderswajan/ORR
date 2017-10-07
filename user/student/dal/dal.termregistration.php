<?php
	/**
	*  Termregistration CRUD
	*/
	require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/connect.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/session.php');
	
	class DALTermregistration
	{
		
		function __construct()
		{

			
		}
		// Entry a new term registration
		public function insert($studentId,$offeredTermId)
		{
			global $con;
			$sql = "INSERT INTO registeredterm VALUES('','$studentId','$offeredTermId',0)";
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

		public function getRegisteredTerm($studentId)
		{
			global $con;
			$sql = "SELECT * FROM registeredterm WHERE studentId=$studentId ORDER BY id ASC";
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

		// Select the next eligible term to be registered
		public function getOfferedTerms($studentId,$varsityDeptId)
		{
			global $con;
			// Query unfinished.... filter: university, dept
			// Select all the Offered terms if,
			// 1. Student already not registered
			// 2. VarsityDeptId same to student varistyDeptId
			// 3. Running
			// 4. Is not locked
			$sql = "SELECT offeredterm.* FROM offeredterm,varsitydept WHERE offeredterm.id NOT IN(SELECT registeredterm.offeredTermId FROM registeredterm WHERE registeredterm.studentId = $studentId) && offeredterm.varsityDeptId = varsitydept.id && varsityDept.id = $varsityDeptId && offeredterm.status = 1 && offeredterm.isLocked = 0 LIMIT 1";
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

			/// Modification needed ... after mark entry calcute mark and modify
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

	}


?>