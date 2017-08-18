<?php
	/**
	*  TermOffer CRUD
	*/
	require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/connect.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/session.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/dal/dal.assigndept.php');

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

			// Extract varsity - dept id
			$assignDept = new DALAssignDept;
			$varsityDeptId ="";
			$result = $assignDept->getId($varsityId,$deptId);
			while ($res = mysqli_fetch_assoc($result)) {
				$varsityDeptId = $res['id'];
			}


			$sql = "INSERT INTO offeredterm(id,degreeId,sessionId,yearId,termId,varsityDeptId,status) VALUES('',".$degreeId.",".$sessionId.",".$yearId.",".$termId.",".$varsityDeptId.",1)";
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

			// Combine varsityDeptId
			$assignDept = new DALAssignDept;
			$varsityDeptId ="";
			$result2 = $assignDept->getId($varsityId,$deptId);
			while ($res2 = mysqli_fetch_assoc($result2)) 
			{
				$varsityDeptId = $res2['id'];
			}

 			$sql = "UPDATE offeredterm SET degreeId = ".$degreeId.", sessionId = ".$sessionId.", yearId = ".$yearId.", termId= ".$termId.", varsityDeptId = ".$varsityDeptId.", status = ".$status." WHERE id= ".$id."";

			$result = mysqli_query($con,$sql);
			if($result)
			{
				return true;
			}
			else
			{
				echo mysqli_error($con);
				echo $sql;
				//echo $status;
				return false;

			}
		}
		public function delete($id)
		{
			global $con;
			$sql = "DELETE FROM offeredterm WHERE id = ".$id;
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