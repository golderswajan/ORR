<?php
/**
*  Course BUISENESS LOGIC LAYER
*  CONNECTS BETWEEN DATA ACCESS LAYER AND PRESENTATION LAYER
*/
require_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/dal/dal.course.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/bll/bll.university.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/bll/bll.department.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/dal/dal.assigndept.php');

// To activate the constructior crating an object. 
$bllCourse = new BLLCourse;

class BLLCourse
{

	function __construct()
	{


		$dalCourse = new DALCourse;

		if(isset($_POST['submit_insert_course']))
		{
			$response="";

			$prefix = $_POST['prefix'];
			$courseNo = $_POST['course_no'];
			$courseTitle = $_POST['course_title'];
			$credit  = $_POST['credit'];
			$prerequisite = $_POST['prerequisite'];
			$yearId  = $_POST['yearId'];
			$termId  = $_POST['termId'];
			$varsityId = $_POST['varsityId'];
			$deptId = $_POST['deptId'];
			$degreeId = $_POST['degreeId'];

			if (ctype_space($prefix) || ctype_space($courseNo) ||ctype_space($courseTitle)||ctype_space($credit))
			{
				$_SESSION['message'] = "One or more field contains spaces only.";
				header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/course.php');
				exit();
				return false;
			}
			else
			{
				$response = $dalCourse->insert($prefix,$courseNo,$courseTitle,$credit,$prerequisite,$yearId,$termId,$varsityId,$deptId,$degreeId);
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

			header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/course.php');
			exit();
		}
		if(isset($_POST['submit_update_course']))
		{
			$id = $_POST['id'];
			$response="";

			$prefix = $_POST['prefix'];
			$courseNo = $_POST['course_no'];
			$courseTitle = $_POST['course_title'];
			$credit  = $_POST['credit'];
			$prerequisite = $_POST['prerequisite'];
			$yearId  = $_POST['yearId'];
			$termId  = $_POST['termId'];
			$varsityId = $_POST['varsityId'];
			$deptId = $_POST['deptId'];
			$degreeId = $_POST['degreeId'];


			if (ctype_space($prefix) || ctype_space($courseNo) ||ctype_space($courseTitle)||ctype_space($credit))
			{
				$_SESSION['message'] = "One or more field contains spaces only.";
				header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/course.php');
				exit();
				return false;
			}
			else
			{
				$response = $dalCourse->update($id,$prefix,$courseNo,$courseTitle,$credit,$prerequisite,$yearId,$termId,$varsityId,$deptId,$degreeId);

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
			header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/course.php');
			exit();

		}
		
		//	Actually geting this request form confirm_delete.js
		if(isset($_GET['submit_delete_course']))
		{
			$id = $_GET['submit_delete_course'];
			$response = $dalCourse->delete($id);
			
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
			
			header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/course.php');
			exit();
		}

	}

	// Display the list of libraries
	public function show()
	{
		$dalCourse = new DALCourse;
		$result = $dalCourse->get();

		$post = "";
		while ($res = mysqli_fetch_assoc($result))
		 {

		 	// Extracting varsityId and deptId form varsityDeptId first.
			$dalAssignDept = new DALAssignDept;
			$bllUniversity = new BLLUniversity;
			$bllDepartment = new BLLDepartment;

		 	$varsityId ="";
		 	$deptId ="";
			$result2 = $dalAssignDept->getById($res['varsityDeptId']);
			while ($res2 = mysqli_fetch_assoc($result2)) 
			{
				$varsityId = $res2['varsityId'];
				$deptId = $res2['deptId'];
			}

		 	$post.= '<tr>';
			$post.= '<td>'.$res["prefix"].'</td>';
			$post.= '<td>'.$res['courseNo'].'</td>';
			$post.= '<td>'.$res["courseTitle"].'</td>';
			$post.= '<td>'.$res["credit"].'</td>';
			$post.= '<td>'.$bllUniversity->getName($varsityId).'</td>';
			$post.= '<td>'.$bllDepartment->getName($deptId).'</td>';
			

			$post.= '<td class="text-right"><button class="btn btn-link" id="btnEdit'.$res["id"].'" onclick="EditCourse('.$res["id"].','.$res["yearId"].','.$res["termId"].','.$varsityId.','.$deptId.','.$res["degreeId"].','.$res["prerequisite"].')">Edit</button></td>';
			$post.= '<td class="text-right"><button id="delete_btn" class="btn btn-link" onclick="delete_btn_click('.$res['id'].',\'/se/dashboard/bll/bll.course.php\',\'submit_delete_course\')">Delete</button></td>';
			$post.= '<td style="display: none" id="row_id'.$res["id"].'">'.$res["id"].'</td>';
		 	$post.= '</tr>';

		 }
		 return $post;
	}

}

?>
