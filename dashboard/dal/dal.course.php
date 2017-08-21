<?php
	/**
	*  Course CRUD
	*/
	require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/connect.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/session.php');
	include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/bll/bll.assigndept.php');

	class DALCourse
	{
		
		function __construct()
		{

			
		}

		public function get()
		{
			global $con;
			$sql = "SELECT * FROM course WHERE 1 ORDER BY courseNo ASC";
			$result = mysqli_query($con,$sql);

			return $result;
		}
		public function getById($id)
		{
			global $con;
			$sql = "SELECT * FROM course WHERE id=".$id;
			$result = mysqli_query($con,$sql);

			return $result;
		}
		public function getyByOfferedTerm($id)
		{
			global $con;
			$sql = "SELECT course.* FROM course,offeredterm WHERE course.varsityDeptId = offeredterm.varsityDeptId  && course.degreeId = offeredterm.degreeId && course.yearId = offeredterm.yearId && course.termId = offeredterm.termId && offeredterm.id=".$id;
			$result = mysqli_query($con,$sql);

			return $result;
		}
		public function getyByOfferedCourse($offeredTermId)
		{
			global $con;
			$sql = "SELECT course.* FROM course,offeredcourse WHERE course.id = offeredcourse.courseId && offeredcourse.offeredTermId=".$offeredTermId;
			$result = mysqli_query($con,$sql);

			return $result;
		}

		public function insert($prefix,$courseNo,$courseTitle,$credit,$prerequisite,$yearId,$termId,$varsityId,$deptId,$degreeId)
		{
			global $con;
			// Combine varsityDeptId
			$bllAssignDept = new BLLAssignDept;
			$varsityDeptId = $bllAssignDept->getVarsityDeptId($varsityId,$deptId);

			$sql = "INSERT INTO course VALUES('','".$prefix."',".$courseNo.",'".$courseTitle."',".$credit.",".$prerequisite.",".$yearId.",".$termId.",".$degreeId.",".$varsityDeptId.")";
			$result = mysqli_query($con,$sql);

			if($result)
			{
				return true;
			}
			else
			{
				echo mysqli_error($con);
				return false;
			}
		}

		public function update($id,$prefix,$courseNo,$courseTitle,$credit,$prerequisite,$yearId,$termId,$varsityId,$deptId,$degreeId)
		{
			global $con;

			$bllAssignDept = new BLLAssignDept;
			$varsityDeptId = $bllAssignDept->getVarsityDeptId($varsityId,$deptId);

			$sql = "UPDATE course SET prefix = '".$prefix."',courseNo = ".$courseNo.",courseTitle = '".$courseTitle."',credit = ".$credit.",yearId = ".$yearId.",termId = ".$termId.",prerequisite= ".$prerequisite.",varsityDeptId = ".$varsityDeptId.",degreeId = ".$degreeId." WHERE id= ".$id."";
			$result = mysqli_query($con,$sql);
			if($result)
			{
				return true;
			}
			else
			{
				//echo mysqli_error($con);
				//echo $sql ;
				return false;

			}
		}
		public function delete($id)
		{
			global $con;
			$sql = "DELETE FROM course WHERE id = ".$id;
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