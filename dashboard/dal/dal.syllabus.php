<?php
	/**
	*  Syllabus CRUD
	*/
	require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/connect.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/session.php');
	
	class DALSyllabus
	{
		
		function __construct()
		{

			
		}

		public function get()
		{
			global $con;
			$sql = "SELECT * FROM syllabus WHERE 1 ORDER BY id ASC";
			$result = mysqli_query($con,$sql);

			return $result;
		}
		public function getById($id)
		{
			global $con;
			$sql = "SELECT * FROM syllabus WHERE id=".$id;
			$result = mysqli_query($con,$sql);

			return $result;
		}


		public function insert($offeredTermId,$minCredit,$maxCredit)
		{
			global $con;
			$sql = "INSERT INTO syllabus VALUES('','$offeredTermId','$minCredit','$maxCredit')";
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

		public function update($id,$offeredTermId,$minCredit,$maxCredit)
		{
			global $con;
			$sql = "UPDATE syllabus SET offeredTermId = ".$offeredTermId.", min = ".$minCredit.", max = ".$maxCredit." WHERE id= ".$id;
			$result = mysqli_query($con,$sql);
			if($result)
			{
				return true;
			}
			else
			{
				echo mysqli_error($con);
				echo $sql;
				return false;
			}
		}
		public function delete($id)
		{
			global $con;
			$sql = "DELETE FROM syllabus WHERE id = $id";
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
	}


?>