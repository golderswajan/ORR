<?php
	/**
	*  CourseOffer CRUD
	*/
	require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/connect.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/session.php');
	
	class DALAssignDept
	{
		
		function __construct()
		{

			
		}

		public function get()
		{
			global $con;
			$sql = "SELECT * FROM varsitydept WHERE 1 ORDER BY id ASC";
			$result = mysqli_query($con,$sql);

			return $result;
		}
		public function getId($varsityId,$deptId)
		{
			global $con;
			$sql = "SELECT * FROM varsitydept WHERE varsityId =".$varsityId." && deptId = ".$deptId."";
			$result = mysqli_query($con,$sql);

			return $result;
		}
		public function getById($id)
		{
			global $con;
			$sql = "SELECT * FROM  varsitydept WHERE id=".$id;
			$result = mysqli_query($con,$sql);

			return $result;
		}
		public function getByUniversityId($varsityId)
		{
			global $con;
			$sql = "SELECT * FROM varsitydept WHERE varsityId =".$varsityId;
			$result = mysqli_query($con,$sql);

			return $result;
		}
		// Varsity and Dept name separately
		public function getVarsityDeptName($varsityDeptId)
		{
			global $con;
			$sql = "SELECT varsity.name as varsityName, dept.name as deptName FROM varsity,dept,varsitydept WHERE varsity.id = varsityDept.varsityId && dept.id = varsityDept.deptId && varsitydept.id =".$varsityDeptId;
			$result = mysqli_query($con,$sql);

			return $result;
		}
		public function insert($varsityId,$deptId)
		{
			global $con;
			$sql = "INSERT INTO varsitydept VALUES('',".$varsityId.",".$deptId.")";
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
		public function exeSql($sql)
		{
			global $con;
			
			$result = mysqli_query($con,$sql);
			if($result)
			{
				return true;
			}
			else
			{	
				//echo $sql;
				//echo mysqli_error($con);
				return false;
			}

		}

		public function update($id,$varsityId,$deptId)
		{
			global $con;
			$sql = "UPDATE varsitydept SET varsityId = ".$varsityId.", deptId = ".$deptId." WHERE id=$id";
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
			$sql = "DELETE FROM varsitydept WHERE id = ".$id;
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