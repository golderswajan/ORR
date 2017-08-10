<?php
/**
*  Course BUISENESS LOGIC LAYER
*  CONNECTS BETWEEN DATA ACCESS LAYER AND PRESENTATION LAYER
*/
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/dal/dal.Course.php');

// To activate the constructior crating an object. 
$Course = new BLLCourse;

class BLLCourse
{

	function __construct()
	{


		$Course = new DALCourse;

		if(isset($_POST['submit_insert']))
		{
			$response="";

			$prefix = $_POST['prefix'];
			$course_no = $_POST['course_no'];
			$course_title = $_POST['course_title'];
			$credit  = $_POST['credit'];
			$prerequisite = $_POST['prerequisite'];
			$yearId  = $_POST['yearId'];
			$termId  = $_POST['termId'];
			$varsityId = $_POST['varsityId'];
			$deptId = $_POST['deptId'];
			$degreeId = $_POST['degreeId'];

			if (ctype_space($prefix) || ctype_space($course_no) ||ctype_space($course_title)||ctype_space($credit))
			{
				$_SESSION['message'] = "One or more field contains spaces only.";
				header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/Course.php');
				exit();
				return false;
			}
			else
			{
				$response = $Course->insert($prefix,$course_no,$course_title,$credit,$prerequisite,$yearId,$termId,$varsityId,$deptId,$degreeId);
			}


			if($response)
			{
				$_SESSION['message'] = "Successfully Inserted.";
			}
			else
			{

				$_SESSION['message'] = "Can't Insert.";
			}


			// Redirect to call page as soon as task done.

			header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/Course.php');
			//exit();
		}
		if(isset($_POST['submit_update']))
		{
			$id = $_POST['id'];
			$response="";

			$prefix = $_POST['prefix'];
			$course_no = $_POST['course_no'];
			$course_title = $_POST['course_title'];
			$credit  = $_POST['credit'];
			$prerequisite = $_POST['prerequisite'];
			$yearId  = $_POST['yearId'];
			$termId  = $_POST['termId'];
			$varsityId = $_POST['varsityId'];
			$deptId = $_POST['deptId'];
			$degreeId = $_POST['degreeId'];


			if (ctype_space($prefix) || ctype_space($course_no) ||ctype_space($course_title)||ctype_space($credit))
			{
				$_SESSION['message'] = "One or more field contains spaces only.";
				header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/Course.php');
				exit();
				return false;
			}
			else
			{
				$response = $Course->update($id,$prefix,$course_no,$course_title,$credit,$prerequisite,$yearId,$termId,$varsityId,$deptId,$degreeId);

			}
			// Redirect to call page as soon as task done.
			if($response)
			{
				$_SESSION['message'] = "Successfully Updated.";
			}
			else
			{
				$_SESSION['message'] = "Can't Update.";
			}
			// Redirect to call page as soon as task done.
			header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/Course.php');
			exit();

		}
		
		//	Actually geting this request form confirm_delete.js
		if(isset($_GET['submit_delete']))
		{
			$id = $_GET['submit_delete'];
			$response = $Course->delete($id);
			
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
			
			header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/Course.php');
			exit();
		}

	}

	// Display the list of libraries
	public function show()
	{
		$Course = new DALCourse;
		$result = $Course->get();

		$post = "";
		while ($res = mysqli_fetch_assoc($result))
		 {
		 	$post.= '<tr>';
			$post.= '<td>'.$res["prefix"].'</td>';
			$post.= '<td>'.$res['course_no'].'</td>';
			$post.= '<td>'.$res["course_title"].'</td>';
			$post.= '<td>'.$res["credit"].'</td>';
			//$post.= '<td>'.$res["yearId"].'</td>';
			//$post.= '<td>'.$res["termId"].'</td>';

			$post.= '<td class="text-right"><button class="btn btn-link" id="btnEdit'.$res["id"].'" onclick="EditCourse('.$res["id"].','.$res["yearId"].','.$res["termId"].','.$res["varsityId"].','.$res["deptId"].','.$res["degreeId"].','.$res["prerequisite"].')">Edit</button></td>';
			$post.= '<td class="text-right"><button id="delete_btn" class="btn btn-link" onclick="delete_btn_click('.$res['id'].',\'/se/dashboard/bll/bll.Course.php\')">Delete</button></td>';
			$post.= '<td style="display: none" id="row_id'.$res["id"].'">'.$res["id"].'</td>';
		 	$post.= '</tr>';

		 }
		 return $post;
	}

}

?>
