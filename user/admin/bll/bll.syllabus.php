<?php
/**
*  UNIVERSITY BUISENESS LOGIC LAYER
*  CONNECTS BETWEEN DATA ACCESS LAYER AND PRESENTATION LAYER
*/
include_once($_SERVER['DOCUMENT_ROOT'].'/se/user/admin/dal/dal.syllabus.php');

// To activate the constructior crating an object. 
$bllSyllabus = new BLLSyllabus;

class BLLSyllabus
{

	function __construct()
	{

		$dalSyllabus = new DALSyllabus;

		if(isset($_POST['submit_insert']))
		{
			$offeredTermId = $_POST['offeredTermId'];
			$minCredit = $_POST['minCredit'];
			$maxCredit = $_POST['maxCredit'];
			if (ctype_space($minCredit) || ctype_space($maxCredit) )
			{
				$_SESSION['message'] = "Contains spaces only.";
				header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/syllabus.php');
				exit();
				return false;
			}
			// Else insert 
			$response = $dalSyllabus->insert($offeredTermId,$minCredit,$maxCredit);

			if($response)
			{
				$_SESSION['message'] = "Successfully Inserted.";
			}
			else
			{
				$_SESSION['message'] = "Can't Insert.";
			}


			// Redirect to call page as soon as task done.

			header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/syllabus.php');
			exit();
		}
		if(isset($_POST['submit_update']))
		{
			$id = $_POST['id'];
			$offeredTermId = $_POST['offeredTermId'];
			$minCredit = $_POST['minCredit'];
			$maxCredit = $_POST['maxCredit'];
			if (ctype_space($minCredit) || ctype_space($maxCredit) )
			{
				$_SESSION['message'] = "Contains spaces only.";
				header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/syllabus.php');
				exit();
				return false;
			}
			// Else insert 
			$response = $dalSyllabus->update($id,$offeredTermId,$minCredit,$maxCredit);

			if($response)
			{
				$_SESSION['message'] = "Successfully Updated.";
			}
			else
			{
				$_SESSION['message'] = "Can't Update.";
			}

			// Redirect to call page as soon as task done.
			
			header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/syllabus.php');
			exit();

		}
		
		//	Actually geting this request form confirm_delete.js
		if(isset($_GET['submit_delete']))
		{
			$id = $_GET['submit_delete'];
			$response = $dalSyllabus->delete($id);
			
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
			
			header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/syllabus.php');
			exit();
		}

	}

	// Display the list of libraries
	public function show($varsityDeptId)
	{
		$dalSyllabus = new DALSyllabus;
		$result = $dalSyllabus->get($varsityDeptId);

		$post = "";
		while ($res = mysqli_fetch_assoc($result))
		 {

          $termInfo = $this->offeredTermInfoById($res["offeredTermId"]);

		 	$post.= '<tr>';
			$post.= '<td>'.$termInfo.'</td>';
			$post.= '<td>'.$res["min"].'</td>';
			$post.= '<td>'.$res["max"].'</td>';
			$post.= '<td class="text-right"><button class="btn btn-link" id="btnEdit'.$res["id"].'" onclick="EditSyllabus('.$res["id"].','.$res["offeredTermId"].')">Edit</button></td>';
			$post.= '<td class="text-right"><button id="delete_btn" class="btn btn-link" onclick="delete_btn_click('.$res['id'].',\'/se/dashboard/bll/bll.syllabus.php\')">Delete</button></td>';
			$post.= '<td style="display: none" id="row_id'.$res["id"].'">'.$res["id"].'</td>';
		 	$post.= '</tr>';

		 }
		 return $post;
	}
	
	// Show offered term list in term label.
	public function offeredTermInfoById($offeredTermId)
	{
		$dalSyllabus = new DALSyllabus;
		$result = $dalSyllabus->offeredTermInfoById($offeredTermId);
		$post = "";
		while ($res = mysqli_fetch_assoc($result))
		 {

			$post.=$res['degreeName'];
			$post.= ' -> '.$res['sessionName'];
			$post.= ' -> '.$res['year'].' - '.$res['term'];

		 }
		 return $post;
	}

	// Show offered term list in term list.
	public function offeredTermInfo($varsityDeptId)
	{
		$dalSyllabus = new DALSyllabus;
		$result = $dalSyllabus->offeredTermInfo($varsityDeptId);
		$post = "";
		while ($res = mysqli_fetch_assoc($result))
		 {	
		 	$post.= '<option value="'.$res['offeredTermId'].'">';
			$post.=$res['degreeName'];
			$post.= ' -> '.$res['sessionName'];
			$post.= ' -> '.$res['year'].' - '.$res['term'];
		 	$post.='</option>';


		 }
		 return $post;
	}
	

}

?>
