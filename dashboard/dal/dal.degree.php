<?php
	/**
	*  Degree CRUD
	*/
	require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/connect.php');
	class DALDegree
	{
		
		function __construct()
		{

			
		}

		public function get()
		{
			global $con;
			$sql = "SELECT * FROM degree WHERE 1 ORDER BY name ASC";
			$result = mysqli_query($con,$sql);

			return $result;
		}

		public function insert($name)
		{
			global $con;
			$sql = "INSERT INTO degree VALUES('','$name')";
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
			$sql = "UPDATE degree SET name = '$name' WHERE id=$id";
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
			$sql = "DELETE FROM degree WHERE id = $id";
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