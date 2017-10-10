<?php
	/**
	*  CourseOffer CRUD
	*/
	require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/connect.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/session.php');
	
	class DALAssignTeacher
	{
		
		function __construct()
		{

			
		}


		// Retrun currently running terms assigned teachers
		public function get($varsityDeptId)
		{
			global $con;
			$sql = "SELECT offeredteacher.id,user.fullName,teacher.designation, course.prefix,course.courseNo,course.courseTitle,course.credit FROM course,offeredcourse,offeredteacher,teacher,user,offeredterm WHERE course.id = offeredcourse.courseId && offeredcourse.offeredTermId = offeredterm.id && offeredterm.status = 1  && offeredcourse.id = offeredteacher.offeredCourseId && offeredteacher.teacherId = teacher.id && teacher.userId = user.id && teacher.varsityDeptId = $varsityDeptId ORDER BY course.courseNo ASC";
			$result = mysqli_query($con,$sql);

			return $result;
		}
		
		public function getTeachers($varsityDeptId)
		{
			global $con;
			$sql = "SELECT user.fullName,teacher.id as teacherId,teacher.designation FROM teacher,user WHERE teacher.userId = user.id && teacher.varsityDeptId = $varsityDeptId";
			$result = mysqli_query($con,$sql);

			return $result;
		}

		// Return courses running in the current session 
		// for a specific varistyDeptId

		public function getCourses($varsityDeptId)
		{
			global $con;
			$sql = "SELECT offeredcourse.id as offeredCourseId, course.prefix,course.courseNo,course.courseTitle,course.credit FROM course,offeredcourse,offeredterm WHERE offeredcourse.courseId = course.id && offeredcourse.offeredTermId = offeredterm.id && offeredterm.status = 1 && offeredterm.varsityDeptId = $varsityDeptId";
			$result = mysqli_query($con,$sql);

			return $result;
		}
		
		public function insert($offeredCourseId,$teacherId)
		{
			global $con;
			$sql = "INSERT INTO offeredteacher VALUES('',".$offeredCourseId.",".$teacherId.")";
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