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

		public function get($varsityDeptId)
		{
			global $con;
			$sql = "SELECT degree.name as degreeName,session.sessionName,year.year,term.term,offeredterm.* FROM offeredterm,degree,session,year,term WHERE offeredterm.degreeId = degree.id && offeredterm.sessionId = session.id && offeredterm.yearId = year.id && offeredterm.termId = term.id && offeredterm.varsityDeptId = $varsityDeptId";
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


		public function insert($degreeId,$sessionId,$yearId,$termId,$varsityDeptId)
		{
			global $con; 

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

		public function update($id,$degreeId,$sessionId,$yearId,$termId,$varsityDeptId,$status)
		{
			global $con;

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
		

		// Get misc. data 
		public function getDegrees($varsityDeptId)
		{
			global $con;
			$sql = "SELECT * FROM degree";
			$result = mysqli_query($con,$sql);

			return $result;
		}
		public function getSessions($varsityDeptId)
		{
			global $con;
			$sql = "SELECT * FROM session";
			$result = mysqli_query($con,$sql);

			return $result;
		}
		public function getYears($varsityDeptId)
		{
			global $con;
			$sql = "SELECT * FROM year";
			$result = mysqli_query($con,$sql);

			return $result;
		}
		public function getTerms($varsityDeptId)
		{
			global $con;
			$sql = "SELECT * FROM term";
			$result = mysqli_query($con,$sql);

			return $result;
		}
	}


?>