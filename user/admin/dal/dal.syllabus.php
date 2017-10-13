<?php
	/**
	*  Syllabus CRUD
	*/
	require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/connect.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/session.php');
	
	class DALSyllabus
	{
		
		function __construct()
		{

			
		}

		public function get($varsityDeptId)
		{
			global $con;
			$sql = "SELECT syllabus.* FROM syllabus,offeredterm WHERE syllabus.offeredTermId = offeredterm.id && offeredterm.varsityDeptId = $varsityDeptId ORDER BY syllabus.id ASC";
			$result = mysqli_query($con,$sql);

			return $result;
		}
		public function getById($id)
		{
			global $con;
			$sql = "SELECT * FROM syllabus WHERE id=".$id;
			$result = mysqli_query($con,$sql);

			return $result;
		}


		public function insert($offeredTermId,$minCredit,$maxCredit)
		{
			global $con;
			$sql = "INSERT INTO syllabus VALUES('','$offeredTermId','$minCredit','$maxCredit')";
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

		public function update($id,$offeredTermId,$minCredit,$maxCredit)
		{
			global $con;
			$sql = "UPDATE syllabus SET offeredTermId = ".$offeredTermId.", min = ".$minCredit.", max = ".$maxCredit." WHERE id= ".$id;
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
			$sql = "DELETE FROM syllabus WHERE id = $id";
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

		public function offeredTermInfoById($offeredTermId)
		{
			global $con;
			$sql = "SELECT session.sessionName,degree.name AS degreeName,year.year,term.term FROM offeredterm,degree,session,year,term WHERE offeredterm.degreeId = degree.id && offeredterm.sessionId = session.id && offeredterm.yearId = year.id && offeredterm.termId = term.id && offeredterm.id = $offeredTermId ORDER BY session.sessionName DESC";
			$result = mysqli_query($con,$sql);
			if($result)
			{
				return $result;
			}
			else
			{
				return false;
			}
		}
		public function offeredTermInfo($varsityDeptId)
		{
			global $con;
			$sql = "SELECT offeredterm.id as offeredTermId,session.sessionName,degree.name AS degreeName,year.year,term.term FROM offeredterm,degree,session,year,term WHERE offeredterm.degreeId = degree.id && offeredterm.sessionId = session.id && offeredterm.yearId = year.id && offeredterm.termId = term.id && offeredterm.varsityDeptId = $varsityDeptId ORDER BY session.sessionName DESC";
			$result = mysqli_query($con,$sql);
			if($result)
			{
				return $result;
			}
			else
			{
				return false;
			}
		}
	}


?>