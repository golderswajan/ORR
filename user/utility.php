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
		
		//***********************************************
		//Redirect to given location
		//***********************************************
		function redirect($location)
		{
			header("Location:".$location);
			exit;
			
		}

		//===================================================================
		// Student Utilities
		//===================================================================


		// Retrive all data associated with student
		public function getStudentInfo($email)
		{
			global $con;
			$sql = "SELECT student.studentId as studentId,varsity.id as varsityId,dept.id as deptId, varsityDept.id as varsityDeptId FROM student,user,varsitydept,varsity,dept WHERE student.userId = user.id && student.varsityDeptId = varsitydept.id && varsitydept.varsityId = varsity.id && varsitydept.deptId = dept.id && user.email = 'shahid.sm35@gmail.com'";
			$result = mysqli_query($con,$sql);

			return $result;
		}

		// Return studentId
		public function getStudentId($email)
		{
			global $con;
			$data = "";
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
			$data = "";
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
			$data = "";

			$result = $this->getStudentInfo($email);
			while ($res = mysqli_fetch_assoc($result))
			{
				$data = $res['deptId'];
			}
			return $data;
		}

		// Return varsityDeptId
		public function getVarsityDeptId($email)
		{
			global $con;
			$data = "";

			$result = $this->getStudentInfo($email);
			while ($res = mysqli_fetch_assoc($result))
			{
				$data = $res['varsityDeptId'];
			}
			return $data;
		}

		//===================================================================
		// Id <--> Data Converters
		//===================================================================

		// Return degreeName
		public function getDegreeName($degreeId)
		{
			global $con;
			$data="";

			$sql = "SELECT * FROM degree WHERE degree.id = $degreeId";
			$result = mysqli_query($con,$sql);
			while ($res = mysqli_fetch_assoc($result))
			{
				$data = $res['name'];
			}
			return $data;
		}
		// Return SessionName
		public function getSessionName($sessionId)
		{
			global $con;
			$data="";
			
			$sql = "SELECT * FROM session WHERE session.id = $sessionId";
			$result = mysqli_query($con,$sql);
			while ($res = mysqli_fetch_assoc($result))
			{
				$data = $res['sessionName'];
			}
			return $data;
		}
		// Return year
		public function getYearName($yearId)
		{
			global $con;
			$data="";
			
			$sql = "SELECT * FROM year WHERE year.id = $yearId";
			$result = mysqli_query($con,$sql);
			while ($res = mysqli_fetch_assoc($result))
			{
				$data = $res['year'];
			}
			return $data;
		}
		// Return term
		public function getTermName($termId)
		{
			global $con;
			$data="";
			
			$sql = "SELECT * FROM term WHERE term.id = $termId";
			$result = mysqli_query($con,$sql);
			while ($res = mysqli_fetch_assoc($result))
			{
				$data = $res['term'];
			}
			return $data;
		}

	}
?>