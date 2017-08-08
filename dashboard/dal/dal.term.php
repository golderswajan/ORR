<?php
	/**
	*  Term CRUD
	*/
	require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/connect.php');
	class DALTerm
	{
		
		function __construct()
		{
	
		}

		public function get()
		{
			global $con;
			$sql = "SELECT * FROM term WHERE 1 ORDER BY term ASC";
			$result = mysqli_query($con,$sql);

			return $result;
		}

		public function insert($term)
		{
			global $con;
			$sql = "INSERT INTO term VALUES('','$term')";
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

		public function update($id,$term)
		{
			global $con;
			$sql = "UPDATE term SET term = '$term' WHERE id=$id";
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
			$sql = "DELETE FROM term WHERE id = $id";
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