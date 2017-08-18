<?php
	/**
	*  ApproveUser CRUD
	*/
	require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/connect.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/session.php');
	
	class DALApproveUser
	{
		
		function __construct()
		{

			
		}

		public function get()
		{
			global $con;
			$sql = "SELECT * FROM user WHERE active = 0 ORDER BY id ASC";
			$result = mysqli_query($con,$sql);

			return $result;
		}
		public function getById($id)
		{
			global $con;
			$sql = "SELECT * FROM user WHERE id=".$id;
			$result = mysqli_query($con,$sql);

			return $result;
		}


		public function approve($id)
		{
			global $con;
			$sql = "UPDATE user SET active = 1 WHERE id = ".$id;
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
		// Approve all users at a time
		public function approveAll()
		{
			global $con;
			$sql = "UPDATE user SET active = 1 WHERE active = 0";
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