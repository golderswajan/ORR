<?php
	/**
	*  User Utility functions here
	*/
	include_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/connect.php');
	$utility = new Utility;
	class Utility
	{
		
		function __construct()
		{
			if (!isset($_SESSION)) 
			{
				session_start();
			}
		}

		//===================================================================
		// Student Utilities
		//===================================================================


		// Retrive all data associated with student
		public function getStudentInfo($email)
		{
			global $con;
			$data = "";
			$sql = "SELECT student.studentId as studentId,varsity.id as varsityId,dept.id as deptId FROM student,user,varsitydept,varsity,dept WHERE student.userId = user.id && student.varsityDeptId = varsitydept.id && varsitydept.varsityId = varsity.id && varsitydept.deptId = dept.id && user.email = 'shahid.sm35@gmail.com'";
			$result = mysqli_query($con,$sql);

			return $result;
		}

		// Return studentId
		public function getStudentId($email)
		{
			global $con;
			$result = $this->getStudentInfo($email);
			while ($res = mysqli_fetch_assoc($result))
			{
				$data = $res['studentId'];
			}
			return $data;
		}
		// Return varsityId
		public function getVarsityId($email)
		{
			global $con;
			$result = $this->getStudentInfo($email);
			while ($res = mysqli_fetch_assoc($result))
			{
				$data = $res['varsityId'];
			}
			return $data;
		}
		// Return deptId
		public function getDeptId($email)
		{
			global $con;
			$result = $this->getStudentInfo($email);
			while ($res = mysqli_fetch_assoc($result))
			{
				$data = $res['deptId'];
			}
			return $data;
		}
	}
?>