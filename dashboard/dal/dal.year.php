<?php
	/**
	*  Year CRUD
	*/
	require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/connect.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/session.php');
	
	class DALYear
	{
		
		function __construct()
		{

		}

		public function get()
		{
			global $con;
			$sql = "SELECT * FROM year WHERE 1 order BY year ASC";
			$result = mysqli_query($con,$sql);

			return $result;
		}

		public function getById($id)
		{
			global $con;
			$sql = "SELECT * FROM year WHERE id=".$id;
			$result = mysqli_query($con,$sql);

			return $result;
		}

		public function insert($year)
		{
			global $con;
			$sql = "INSERT INTO year VALUES('','$year')";
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

		public function update($id,$year)
		{
			global $con;
			$sql = "UPDATE year SET year = '$year' WHERE id=$id";
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
			$sql = "DELETE FROM year WHERE id = $id";
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