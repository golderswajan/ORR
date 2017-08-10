<?php
	/**
	*  TermOffer CRUD
	*/
	require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/connect.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/session.php');
	class DALTermOffer
	{
		
		function __construct()
		{

			
		}

		public function get()
		{
			global $con;
			$sql = "SELECT * FROM offeredterm WHERE 1";
			$result = mysqli_query($con,$sql);

			return $result;
		}
		public function getById($id)
		{
			global $con;
			$sql = "SELECT * FROM offeredterm WHERE id=".$id;
			$result = mysqli_query($con,$sql);

			return $result;
		}


		public function insert($degreeId,$sessionId,$yearId,$termId,$varsityId,$deptId)
		{
			global $con;
			$sql = "INSERT INTO offeredterm VALUES('',".$degreeId.",".$sessionId.",".$yearId.",".$termId.",".$varsityId.",".$deptId.",1)";
			$result = mysqli_query($con,$sql);

			if($result)
			{
				return true;
			}
			else
			{
				//echo mysqli_error($con);
				return false;
			}
		}

		public function update($id,$degreeId,$sessionId,$yearId,$termId,$varsityId,$deptId,$status)
		{
			global $con;
			//$sql = "UPDATE offeredterm SET degreeId = ".$degreeId.",sessionId = ".$sessionId.",yearId = ".$yearId.",termId= ".$termId.",varsityId = ".$varsityId.",deptId = ".$deptId.",status = ".$status." WHERE id= ".$id;

			// I can't figure whats the error in $sql :-(
 			$sql = "UPDATE offeredterm SET degreeId = ".$degreeId.",sessionId = ".$sessionId.",yearId = ".$yearId.",termId= ".$termId.",varsityId = ".$varsityId.",deptId = ".$deptId.",status = ".$status." WHERE id= ".$id."";

			$result = mysqli_query($con,$sql);
			if($result)
			{
				return true;
			}
			else
			{
				echo mysqli_error($con);
				echo $status;
				return false;

			}
		}
		public function delete($id)
		{
			global $con;
			$sql = "DELETE FROM offeredterm WHERE id = $id";
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