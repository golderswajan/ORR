<?php
	/**
	*  CourseOffer CRUD
	*/
	require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/connect.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/session.php');
	
	class DALCourseOffer
	{
		
		function __construct()
		{

			
		}

		public function get($varsityDeptId)
		{
			global $con;
			$sql = "SELECT offeredcourse.* FROM offeredcourse,offeredterm WHERE offeredcourse.offeredTermId = offeredterm.id && offeredterm.varsityDeptId = $varsityDeptId ORDER BY offeredcourse.id ASC";
			$result = mysqli_query($con,$sql);

			return $result;
		}
		public function getById($id)
		{
			global $con;
			$sql = "SELECT * FROM  offeredcourse WHERE id=".$id;
			$result = mysqli_query($con,$sql);

			return $result;
		}


		public function insert($name)
		{
			global $con;
			$sql = "INSERT INTO varsity VALUES('','$name')";
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
		public function insertMultiple($sql)
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

		public function update($id,$name)
		{
			global $con;
			$sql = "UPDATE varsity SET name = '$name' WHERE id=$id";
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
			$sql = "DELETE FROM varsity WHERE id = $id";
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
		public function getCourseByOfferedTerm($offeredTermId)
		{
			global $con;
			$sql = "SELECT course.* FROM course,offeredterm WHERE course.varsityDeptId = offeredterm.varsityDeptId  && course.degreeId = offeredterm.degreeId && course.yearId = offeredterm.yearId && course.termId = offeredterm.termId && offeredterm.id=".$offeredTermId;
			$result = mysqli_query($con,$sql);

			return $result;
	}

}



?>