<?php
	/**
	*  Registration CRUD
	*/
	require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/connect.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/session.php');
	
	class DALRegistration
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