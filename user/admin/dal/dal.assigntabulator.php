<?php
	/**
	*  CourseOffer CRUD
	*/
	require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/connect.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/session.php');
	
	class DALAssignTabulator
	{
		
		function __construct()
		{

			
		}


		// Retrun currently running terms assigned teachers
		public function get($varsityDeptId)
		{
			global $con;
			$sql = "SELECT offeredterm.id as offeredTermId,session.sessionName,degree.name AS degreeName,year.year,term.term,user.fullName FROM offeredterm,degree,session,year,term,tabulator,user WHERE offeredterm.degreeId = degree.id && offeredterm.sessionId = session.id && offeredterm.yearId = year.id && offeredterm.termId = term.id && offeredterm.id = tabulator.offeredTermId && tabulator.userId = user.id && offeredterm.varsityDeptId = $varsityDeptId ORDER BY session.sessionName DESC";
			$result = mysqli_query($con,$sql);

			return $result;
		}
		
		public function getTabulators()
		{
			global $con;
			$sql = "SELECT user.* FROM user,role WHERE user.roleId = role.id && role.roleName = 'Tabulator'";
			$result = mysqli_query($con,$sql);

			return $result;
		}

		// Return courses running in the current session 
		// for a specific varistyDeptId

		public function getOfferedTerms($varsityDeptId)
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
		
		public function insert($offeredTermId,$userId)
		{
			global $con;
			$sql = "INSERT INTO tabulator VALUES('',".$offeredTermId.",".$userId.")";
			$result = mysqli_query($con,$sql);
			if($result)
			{
				return true;
			}
			else
			{
				// echo mysqli_error($con);
				// echo $sql;
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