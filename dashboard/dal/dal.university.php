<?php
	/**
	*  University CRUD
	*/

	class DALUniversity
	{
		
		function __construct()
		{
			$host = "localhost";
			$user = "root";
			$password = "";
			$db = "se";
			global $con;  // can't say the null return behaviour
			$con = mysqli_connect($host,$user,$password,$db) or die ("Couldn't connnect".mysql_error());

			
		}

		public function get()
		{
			global $con;
			$sql = "SELECT * FROM varsity WHERE 1";
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