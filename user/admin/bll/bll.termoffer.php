<?php
/**
*  TERM OFFER BUISENESS LOGIC LAYER
*  CONNECTS BETWEEN DATA ACCESS LAYER AND PRESENTATION LAYER
*/
require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/connect.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/se/user/admin/dal/dal.termoffer.php');


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
			$varsityDeptId = $_POST['varsityDeptId'];

			$response = $dalTermOffer->insert($degreeId,$sessionId,$yearId,$termId,$varsityDeptId);
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
			header('Location:'.$_SERVER['HTTP_REFERER']);
			
			exit();
		}
		if(isset($_POST['submit_update_termoffer']))
		{
			global $con;
			
			$id = $_POST['id'];
			$degreeId = $_POST['degreeId'];
			$sessionId = $_POST['sessionId'];
			$yearId  = $_POST['yearId'];
			$termId  = $_POST['termId'];
			$varsityDeptId = $_POST['varsityDeptId'];
			$status = $_POST['status'];

			$response="";
			$response = $dalTermOffer->update($id,$degreeId,$sessionId,$yearId,$termId,$varsityDeptId,$status);

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
			header('Location:'.$_SERVER['HTTP_REFERER']);
			
			exit();

		}

	}

	// Display the list of libraries
	public function show($varsityDeptId)
	{
		$dalTermOffer = new DALTermOffer;
		$result = $dalTermOffer->get($varsityDeptId);

		$post = "";
		while ($res = mysqli_fetch_assoc($result))
		 {

		 	// Get the text against all the id's.
			$session =$res["sessionName"];
			$term =$res["term"];
			$year =$res["year"];
			$degree =$res["degreeName"];

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
			$post.= '<td>'.$degree.'</td>';
			$post.= '<td>'.$session.'</td>';
			$post.= '<td>'.$year.' - '.$term.'</td>';
			$post.= '<td>'.$status.'</td>';

			$post.= '<td class="text-right"><button class="btn btn-link" id="btnEdit'.$res["id"].'" onclick="EditTermOffer('.$res["id"].','.$res["yearId"].','.$res["termId"].','.$res["degreeId"].','.$res["sessionId"].','.$varsityDeptId.')">Edit</button></td>';

			$post.= '<td style="display: none" id="row_id'.$res["id"].'">'.$res["id"].'</td>';
		 	$post.= '</tr>';

		 }
		 return $post;
	}

	// Return raw data form database
	public function getRawData($varsityDeptId)
	{
		$dalTermOffer = new DALTermOffer;
		$result = $dalTermOffer->get($varsityDeptId);
		return $result;
	}
	public function getDegrees($varsityDeptId)
	{
		$dalTermOffer = new DALTermOffer;
		$result = $dalTermOffer->getDegrees($varsityDeptId);
		return $result;
	}
	public function getSessions($varsityDeptId)
	{
		$dalTermOffer = new DALTermOffer;
		$result = $dalTermOffer->getSessions($varsityDeptId);
		return $result;
	}
	public function getYears($varsityDeptId)
	{
		$dalTermOffer = new DALTermOffer;
		$result = $dalTermOffer->getYears($varsityDeptId);
		return $result;
	}
	public function getTerms($varsityDeptId)
	{
		$dalTermOffer = new DALTermOffer;
		$result = $dalTermOffer->getTerms($varsityDeptId);
		return $result;
	}


}

?>
