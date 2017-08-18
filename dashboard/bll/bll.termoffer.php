<?php
/**
*  TERM OFFER BUISENESS LOGIC LAYER
*  CONNECTS BETWEEN DATA ACCESS LAYER AND PRESENTATION LAYER
*/
require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/connect.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/dal/dal.termoffer.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/bll/bll.university.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/bll/bll.department.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/bll/bll.session.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/bll/bll.year.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/bll/bll.term.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/bll/bll.degree.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/dal/dal.assigndept.php');


// To activate the constructior crating an object. 
$bllTermOffer = new BLLTermOffer;

class BLLTermOffer
{

	function __construct()
	{


		$dalTermOffer = new DALTermOffer;

		if(isset($_POST['submit_insert_termoffer']))
		{
			$response="";

			$degreeId = $_POST['degreeId'];
			$sessionId = $_POST['sessionId'];
			$yearId  = $_POST['yearId'];
			$termId  = $_POST['termId'];
			$varsityId = $_POST['varsityId'];
			$deptId = $_POST['deptId'];

			$response = $dalTermOffer->insert($degreeId,$sessionId,$yearId,$termId,$varsityId,$deptId);
			if($response)
			{
				$_SESSION['message'] = "Successfully Inserted.";
			}
			else
			{
				//global $con;
				//echo mysqli_error($con);
				$_SESSION['message'] = "Can't Insert.";
			}

			// Redirect to call page as soon as task done.
			header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/termoffer.php');
			exit();
		}
		if(isset($_POST['submit_update_termoffer']))
		{
			global $con;
			$id = $_POST['id'];
			$response="";

			$degreeId = $_POST['degreeId'];
			$sessionId = $_POST['sessionId'];
			$yearId  = $_POST['yearId'];
			$termId  = $_POST['termId'];
			$varsityId = $_POST['varsityId'];
			$deptId = $_POST['deptId'];
			$status = $_POST['status'];

			$response = $dalTermOffer->update($id,$degreeId,$sessionId,$yearId,$termId,$varsityId,$deptId,$status);

			// Redirect to call page as soon as task done.
			if($response)
			{
				$_SESSION['message'] = "Successfully Updated.";
			}
			else
			{

				echo mysqli_error($con);

				$_SESSION['message'] = "Can't Update.".mysqli_error($con);
			}
			// Redirect to call page as soon as task done.
			header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/termoffer.php');
			exit();

		}
		
		//	Actually geting this request form confirm_delete.js
		if(isset($_GET['submit_delete']))
		{
			$dalTermOffer = new DALTermOffer;
			$id = $_GET['id'];
			$response = $dalTermOffer->delete($id);
			
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
			
			header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/termoffer.php');
			exit();
		}

	}

	// Display the list of libraries
	public function show()
	{
		$bllUniversity = new BLLUniversity;
		$bllDepartment = new BLLDepartment;
		$bllSession = new BLLSession;
		$bllTerm = new BLLTerm;
		$bllYear = new BLLYear;
		$bllDegree = new BLLDegree;

		$dalTermOffer = new DALTermOffer;
		$result = $dalTermOffer->get();

		$post = "";
		while ($res = mysqli_fetch_assoc($result))
		 {


		 	// Extracting varsityId and deptId form varsityDeptId first.
			$assignDept = new DALAssignDept;

		 	$varsityId ="";
		 	$deptId ="";
			$result2 = $assignDept->getById($res['varsityDeptId']);
			while ($res2 = mysqli_fetch_assoc($result2)) 
			{
				$varsityId = $res2['varsityId'];
				$deptId = $res2['deptId'];
			}
		 	// Get the text against all the id's.
		 	$varsity = $bllUniversity->getName($varsityId);
			$dept = $bllDepartment->getName($deptId);
			$session = $bllSession->getSessionName($res["sessionId"]);
			$term = $bllTerm->getTerm($res["termId"]);
			$year = $bllYear->getYear($res["yearId"]);
			$degree = $bllDegree->getDegree($res["degreeId"]);

			$status = $res['status'];
			if($status==0)
			{
				$status = "Terminated";
			}
			else if($status==1)
			{
				$status = "Running";
			}

		 	$post.= '<tr>';
			$post.= '<td>'.$varsity.'</td>';
			$post.= '<td>'.$dept.'</td>';
			$post.= '<td>'.$session.'</td>';
			$post.= '<td>'.$year.' - '.$term.'</td>';
			$post.= '<td>'.$status.'</td>';

			$post.= '<td class="text-right"><button class="btn btn-link" id="btnEdit'.$res["id"].'" onclick="EditTermOffer('.$res["id"].','.$res["yearId"].','.$res["termId"].','.$varsityId.','.$deptId.','.$res["degreeId"].','.$res["sessionId"].')">Edit</button></td>';
			//$post.= '<td class="text-right"><button id="delete_btn" class="btn btn-link" onclick="delete_btn_click('.$res['id'].',\'/se/dashboard/bll/bll.termoffer.php\')">Delete</button></td>';
			$post.= '<td style="display: none" id="row_id'.$res["id"].'">'.$res["id"].'</td>';
		 	$post.= '</tr>';

		 }
		 return $post;
	}

}

?>
