<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/se/user/admin/dal/dal.assignteacher.php');



// To activate the constructior crating an object. 
$bllAssignTeacher = new BLLAssignTeacher;

class BLLAssignTeacher
{

	function __construct()
	{

		$dalAssignTeacher = new DALAssignTeacher;

		// Multiple insert 
		if(isset($_POST['assign_teacher']))
		{
			$teacherId = $_POST['teacherId'];

			$response = 0;
			foreach($_POST['offeredCourseId'] as $offeredCourseId)
			{
				$response = $dalAssignTeacher->insert($offeredCourseId,$teacherId);
			}
			if($response)
			{

				$_SESSION['message'] = "Successfully Assigned to the course(s).";
			}
			else
			{
				$_SESSION['message'] = "Can't Assign.";
			}

			header('Location:'.$_SERVER['HTTP_REFERER']);
			
			exit();
		}

		
		//	Actually geting this request form confirm_delete.js
		if(isset($_GET['submit_delete_assigndept']))
		{
			$id = $_GET['submit_delete_assigndept'];
			$response = $dalAssignTeacher->delete($id);
			
			// Redirect to call page as soon as task done.
			if($response)
			{
				$_SESSION['message'] = "Successfully Deleted";
			}
			else 
			{
				$_SESSION['message'] = "Can't Delete";
			}
			// Redirect to call page as soon as task done.
			
			header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/assigndept.php');
			exit();
		}

	}

	// Display the list 
	public function show($varsityDeptId)
	{
		$dalAssignTeacher = new DALAssignTeacher;
		$result = $dalAssignTeacher->get($varsityDeptId);

		$post = "";
		while ($res = mysqli_fetch_assoc($result))
		 {

		 	$post.= '<tr>';
			$post.= '<td>'.$res['designation']." ".$res["fullName"].'</td>';
			$post.= '<td>'.$res['prefix']." ".$res["courseNo"]."->".$res["courseTitle"]."->".$res["credit"].'</td>';
			
			$post.= '<td class="text-right"><button  class="btn btn-link">Edit</button></td>';
	
		 	$post.= '</tr>';

		 }
		 return $post;
	}
	
	public function getTeachers($varsityDeptId)
	{
		$dalAssignTeacher = new DALAssignTeacher;
		$result = $dalAssignTeacher->getTeachers($varsityDeptId);
		$post = "";
		while($res = mysqli_fetch_assoc($result))
          {
              $post.= '<option value='.$res['teacherId'].'>';
              $post.= $res['designation']." ";
              $post.= $res['fullName'];
              $post.= '</option>';
          }
		return $post;
	}
	// Return courses running in the current session 
	// for a specific varistyDeptId
	public function getCourses($varsityDeptId)
	{
		$dalAssignTeacher = new DALAssignTeacher;
		$result = $dalAssignTeacher->getCourses($varsityDeptId);
		$post = "";
        while ($res = mysqli_fetch_assoc($result))
        {
          $post.= '<option value='.$res['offeredCourseId'].'>';
          $post.= $res['prefix']." ".$res['courseNo']."->".$res['courseTitle']."->".$res['credit'];
          $post.= '</option>';
        }
        return $post;
	}
	
}

?>
