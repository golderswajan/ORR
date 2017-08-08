<?php
	/**
	*  Session CRUD
	*/
	require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/connect.php');
	class DALSession
	{
		
		function __construct()
		{

		}

		public function get()
		{
			global $con;
			$sql = "SELECT * FROM session WHERE 1 ORDER BY sessionName DESC";
			$result = mysqli_query($con,$sql);

			return $result;
		}

		public function insert($name)
		{
			global $con;
			$sql = "INSERT INTO session VALUES('','$name')";
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
			$sql = "UPDATE session SET sessionName = '$name' WHERE id=$id";
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
			$sql = "DELETE FROM session WHERE id = $id";
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