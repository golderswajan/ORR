<?php
/**
*  UNIVERSITY BUISENESS LOGIC LAYER
*  CONNECTS BETWEEN DATA ACCESS LAYER AND PRESENTATION LAYER
*/
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/dal/dal.role.php');

// To activate the constructior crating an object. 
$bllRole = new BLLRole;

class BLLRole
{

	function __construct()
	{

		$dalRole = new DALRole;

		if(isset($_POST['submit_insert']))
		{
			$roleName = $_POST['roleName'];
			if (ctype_space($roleName))
			{
				$_SESSION['message'] = "Contains spaces only.";
				header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/role.php');
				exit();
				return false;
			}
			// Else insert 
			$response = $dalRole->insert($roleName);

			if($response)
			{
				$_SESSION['message'] = "Successfully Inserted.";
			}
			else
			{
				$_SESSION['message'] = "Can't Insert.";
			}


			// Redirect to call page as soon as task done.

			header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/role.php');
			exit();
		}
		if(isset($_POST['submit_update']))
		{
			$id = $_POST['id'];
			$roleName = $_POST['roleName'];

			if (ctype_space($roleName))
			{
				$_SESSION['message'] = "Contains spaces only.";
				header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/role.php');
				exit();
				return false;
			}

			$response = $dalRole->update($id,$roleName);
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
			header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/role.php');
			exit();

		}
		
		//	Actually geting this request form confirm_delete.js
		if(isset($_GET['submit_delete']))
		{
			$id = $_GET['submit_delete'];
			$response = $dalRole->delete($id);
			
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
			
			header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/role.php');
			exit();
		}

	}

	// Display the list of libraries
	public function show()
	{
		$dalRole = new DALRole;
		$result = $dalRole->get();

		$post = "";
		while ($res = mysqli_fetch_assoc($result))
		 {
		 	$post.= '<tr>';
			$post.= '<td>'.$res["roleName"].'</td>';
			$post.= '<td class="text-right"><button class="btn btn-link" id="btnEdit'.$res["id"].'" onclick="EditRole('.$res["id"].')">Edit</button></td>';
			$post.= '<td class="text-right"><button id="delete_btn" class="btn btn-link" onclick="delete_btn_click('.$res['id'].',\'/se/dashboard/bll/bll.role.php\')">Delete</button></td>';
			$post.= '<td style="display: none" id="row_id'.$res["id"].'">'.$res["id"].'</td>';
		 	$post.= '</tr>';

		 }
		 return $post;
	}

}

?>
