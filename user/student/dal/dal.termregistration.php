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
		public function getOfferedTerms($studentId)
		{
			global $con;
			// Query unfinished.... filter: university, dept
			$sql = "SELECT * FROM offeredterm WHERE offeredterm.id NOT IN(SELECT registeredterm.offeredTermId FROM registeredterm WHERE registeredterm.studentId = $studentId) LIMIT 1";
			$result = mysqli_query($con,$sql);

			return $result;
		}


		public function insert($studentId,$offeredTermId)
		{
			global $con;
			$sql = "INSERT INTO registeredterm VALUES('','$studentId','$offeredTermId')";
			$result = mysqli_query($con,$sql);
			if($result)
			{
				return true;
			}
			else
			{
				//debug_backtrace();
				return false;
			}
		}

	}


?>