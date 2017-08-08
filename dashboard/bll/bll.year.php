<?php
/**
*  UNIVERSITY BUISENESS LOGIC LAYER
*  CONNECTS BETWEEN DATA ACCESS LAYER AND PRESENTATION LAYER
*/
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/dal/dal.year.php');

// To activate the constructior crating an object. 
$Year = new BLLYear;

class BLLYear
{

	function __construct()
	{

		// Starting session to exchance server messages.
		if(!isset($_SESSION))
		{
		  session_start();
		}

		$Year = new DALYear;

		if(isset($_POST['submit_insert']))
		{
			$year = $_POST['year'];
			if (ctype_space($year))
			{
				$_SESSION['message'] = "Contains spaces only.";
				header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/year.php');
				exit();
				return false;
			}
			// Else insert 
			$response = $Year->insert($year);

			if($response)
			{
				$_SESSION['message'] = "Successfully Inserted.";
			}
			else
			{
				$_SESSION['message'] = "Can't Insert.";
			}


			// Redirect to call page as soon as task done.

			header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/year.php');
			exit();
		}
		if(isset($_POST['submit_update']))
		{
			$id = $_POST['id'];
			$year = $_POST['year'];

			if (ctype_space($year))
			{
				$_SESSION['message'] = "Contains spaces only.";
				header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/year.php');
				exit();
				return false;
			}

			$response = $Year->update($id,$year);
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
			header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/year.php');
			exit();

		}
		
		//	Actually geting this request form confirm_delete.js
		if(isset($_GET['submit_delete']))
		{
			$id = $_GET['submit_delete'];
			$response = $Year->delete($id);
			
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
			
			header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/year.php');
			exit();
		}

	}

	// Display the list of libraries
	public function show()
	{
		$Year = new DALyear;
		$result = $Year->get();

		$post = "";
		while ($res = mysqli_fetch_assoc($result))
		 {
		 	$post.= '<tr>';
			$post.= '<td>'.$res["year"].'</td>';
			$post.= '<td><button class="btn btn-link" id="btnEdit'.$res["id"].'" onclick="EditYear('.$res["id"].')">Edit</button></td>';
			$post.= '<td><button id="delete_btn" class="btn btn-link" onclick="delete_btn_click('.$res['id'].',\'/se/dashboard/bll/bll.year.php\')">Delete</button></td>';
			$post.= '<td style="display: none" id="row_id'.$res["id"].'">'.$res["id"].'</td>';
		 	$post.= '</tr>';

		 }
		 return $post;
	}

}

?>
