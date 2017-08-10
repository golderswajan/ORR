<?php
	/**
	*  University CRUD
	*/
	require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/connect.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/session.php');
	
	class DALUniversity
	{
		
		function __construct()
		{

			
		}

		public function get()
		{
			global $con;
			$sql = "SELECT * FROM varsity WHERE 1 ORDER BY name ASC";
			$result = mysqli_query($con,$sql);

			return $result;
		}
		public function getById($id)
		{
			global $con;
			$sql = "SELECT * FROM varsity WHERE id=".$id;
			$result = mysqli_query($con,$sql);

			return $result;
		}


		public function insert($name)
		{
			global $con;
			$sql = "INSERT INTO varsity VALUES('','$name')";
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

		public function update($id,$name)
		{
			global $con;
			$sql = "UPDATE varsity SET name = '$name' WHERE id=$id";
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
		public function delete($id)
		{
			global $con;
			$sql = "DELETE FROM varsity WHERE id = $id";
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