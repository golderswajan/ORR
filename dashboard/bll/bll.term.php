<?php
/**
*  UNIVERSITY BUISENESS LOGIC LAYER
*  CONNECTS BETWEEN DATA ACCESS LAYER AND PRESENTATION LAYER
*/
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/dal/dal.term.php');

// To activate the constructior crating an object. 
$bllTerm = new BLLTerm;

class BLLTerm
{

	function __construct()
	{

		$dalTerm = new DALTerm;

		if(isset($_POST['submit_insert']))
		{
			$term = $_POST['term'];
			if (ctype_space($term))
			{
				$_SESSION['message'] = "Contains spaces only.";
				header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/term.php');
				exit();
				return false;
			}
			// Else insert 
			$response = $dalTerm->insert($term);

			if($response)
			{
				$_SESSION['message'] = "Successfully Inserted.";
			}
			else
			{
				$_SESSION['message'] = "Can't Insert.";
			}


			// Redirect to call page as soon as task done.

			header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/term.php');
			exit();
		}
		if(isset($_POST['submit_update']))
		{
			$id = $_POST['id'];
			$term = $_POST['term'];

			if (ctype_space($term))
			{
				$_SESSION['message'] = "Contains spaces only.";
				header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/term.php');
				exit();
				return false;
			}

			$response = $dalTerm->update($id,$term);
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
			header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/term.php');
			exit();

		}
		
		//	Actually geting this request form confirm_delete.js
		if(isset($_GET['submit_delete']))
		{
			$id = $_GET['submit_delete'];
			$response = $dalTerm->delete($id);
			
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
			
			header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/term.php');
			exit();
		}

	}

	// Display the list of libraries
	public function show()
	{
		$dalTerm = new DALTerm;
		$result = $dalTerm->get();

		$post = "";
		while ($res = mysqli_fetch_assoc($result))
		 {
		 	$post.= '<tr>';
			$post.= '<td>'.$res["term"].'</td>';
			$post.= '<td class="text-right"><button class="btn btn-link" id="btnEdit'.$res["id"].'" onclick="EditTerm('.$res["id"].')">Edit</button></td>';
			$post.= '<td class="text-right"><button id="delete_btn" class="btn btn-link" onclick="delete_btn_click('.$res['id'].',\'/se/dashboard/bll/bll.term.php\')">Delete</button></td>';
			$post.= '<td style="display: none" id="row_id'.$res["id"].'">'.$res["id"].'</td>';
		 	$post.= '</tr>';

		 }
		 return $post;
	}

	// Give the id, will return the name/[]Name dealing with DAL.
	public function getTerm($id)
	{
		$dalTerm = new DALTerm;
		$result = $dalTerm->getById($id);

		$data = "";
		while ($res = mysqli_fetch_assoc($result))
		 {
			$data.= $res["term"];
			

		 }
		 return $data;
	}


}

?>
