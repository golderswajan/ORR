<?php
/**
*  UNIVERSITY BUISENESS LOGIC LAYER
*  CONNECTS BETWEEN DATA ACCESS LAYER AND PRESENTATION LAYER
*/
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/bll/bll.university.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/bll/bll.department.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/dal/dal.assigndept.php');



// To activate the constructior crating an object. 
$bllAssignDept = new BLLAssignDept;

class BLLAssignDept
{

	function __construct()
	{

		$dalAssignDept = new DALAssignDept;

		// Multiple insert 
		if(isset($_POST['insert_submit']))
		{
			$varsityId = $_POST['university'];

			$response = 0;
			foreach($_POST['departments'] as $departmentId)
			{
				$sql = " INSERT INTO varsitydept VALUES('',".$varsityId.",".$departmentId.") ";
				$response = $dalAssignDept->exeSql($sql);
			}



			if($response)
			{
				session_unset();

				$_SESSION['message'] = "Successfully Inserted.";
			}
			else
			{
				$_SESSION['message'] = "Can't Insert. Check if departments already exists.";
			}

			header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/assigndept.php');
			exit();
		}

		// Search departments for checking..
		if(isset($_POST['search_dept']))
		{
			$varsityId = $_POST['university'];
			$_SESSION['varsityId'] = $varsityId;

			header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/assigndept.php');
			exit();
		}


		//	Actually geting this request form confirm_delete.js
		if(isset($_GET['submit_delete']))
		{
			$id = $_GET['submit_delete'];
			$response = $dalAssignDept->delete($id);
			
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
	public function show()
	{
		$dalAssignDept = new DALAssignDept;
		$result = $dalAssignDept->get();
		$departmentName = new BLLDepartment;
		$post = "";
		while ($res = mysqli_fetch_assoc($result))
		 {

		 	$post.= '<tr>';
			$post.= '<td>'.$departmentName->getName($res["deptId"]).'</td>';
			
			$post.= '<td class="text-right"><button id="delete_btn" class="btn btn-link" onclick="delete_btn_click('.$res['id'].',\'/se/dashboard/bll/bll.assigndept.php\')">Delete</button></td>';
			$post.= '<td style="display: none" id="row_id'.$res["id"].'">'.$res["id"].'</td>';
		 	$post.= '</tr>';

		 }
		 return $post;
	}
	
	// Give the id, will return the name/[]Name dealing with DAL.
	public function getName($id)
	{
		$dalAssignDept = new DALAssignDept;
		$result = $dalAssignDept->getById($id);

		$data = "";
		while ($res = mysqli_fetch_assoc($result))
		 {
			$data.= $res["name"];
			

		 }
		 return $data;
	}
	// Return varsityDeptId combining varsity + dept 
	public function getVarsityDeptId($varsityId,$deptId)
	{

		$assignDept = new DALAssignDept;
		$varsityDeptId ="";
		$result = $assignDept->getId($varsityId,$deptId);
		while ($res = mysqli_fetch_assoc($result)) 
		{
			$varsityDeptId = $res['id'];
		}
		return $varsityDeptId;

	}
	// Show offered term list in term selection box.
	public function showBySelection($varsityId)
	{
		// $id is varsity id 
		
		// Read all from versitydept.
		$dalAssignDept = new DALAssignDept;
		$result = $dalAssignDept->getByUniversityId($varsityId); 
		
		// helps to convert deptId to deptName
		$departmentName = new BLLDepartment;
		$post = "";
		while ($res = mysqli_fetch_assoc($result))
		 {

		 	$post.= '<tr>';
		 	// deptId comes form varsitydept table by exeSql
			$post.= '<td>'.$departmentName->getName($res["deptId"]).'</td>';
			
			$post.= '<td class="text-right"><button id="delete_btn" class="btn btn-link" onclick="delete_btn_click('.$res['id'].',\'/se/dashboard/bll/bll.assigndept.php\')">Delete</button></td>';
			$post.= '<td style="display: none" id="row_id'.$res["id"].'">'.$res["id"].'</td>';
		 	$post.= '</tr>';
		 }
		 return $post;
	}

}

?>
