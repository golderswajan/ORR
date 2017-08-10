<?php
/**
*  TERM OFFER BUISENESS LOGIC LAYER
*  CONNECTS BETWEEN DATA ACCESS LAYER AND PRESENTATION LAYER
*/
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/dal/dal.termoffer.php');

include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/bll/bll.university.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/bll/bll.department.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/bll/bll.session.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/bll/bll.year.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/bll/bll.term.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/bll/bll.degree.php');


// To activate the constructior crating an object. 
$TermOffer = new BLLTermOffer;

class BLLTermOffer
{

	function __construct()
	{


		$TermOffer = new DALTermOffer;

		if(isset($_POST['submit_insert']))
		{
			$response="";

			$degreeId = $_POST['degreeId'];
			$sessionId = $_POST['sessionId'];
			$yearId  = $_POST['yearId'];
			$termId  = $_POST['termId'];
			$varsityId = $_POST['varsityId'];
			$deptId = $_POST['deptId'];
			

			/*if (ctype_space($prefix) || ctype_space($course_no) ||ctype_space($course_title)||ctype_space($credit))
			{
				$_SESSION['message'] = "One or more field contains spaces only.";
				header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/termoffer.php');
				exit();
				return false;
			}*/

			$response = $TermOffer->insert($degreeId,$sessionId,$yearId,$termId,$varsityId,$deptId);


			if($response)
			{
				$_SESSION['message'] = "Successfully Inserted.";
			}
			else
			{

				$_SESSION['message'] = "Can't Insert.";
			}


			// Redirect to call page as soon as task done.

			header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/termoffer.php');
			//exit();
		}
		if(isset($_POST['submit_update']))
		{
			$id = $_POST['id'];
			$response="";

			$degreeId = $_POST['degreeId'];
			$sessionId = $_POST['sessionId'];
			$yearId  = $_POST['yearId'];
			$termId  = $_POST['termId'];
			$varsityId = $_POST['varsityId'];
			$deptId = $_POST['deptId'];
			$status = $_POST['status'];


			/*if (ctype_space($prefix) || ctype_space($course_no) ||ctype_space($course_title)||ctype_space($credit))
			{
				$_SESSION['message'] = "One or more field contains spaces only.";
				header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/termoffer.php');
				exit();
				return false;
			}*/

			$response = $TermOffer->update($id,$degreeId,$sessionId,$yearId,$termId,$varsityId,$deptId,$status);

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
			header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/termoffer.php');
			exit();

		}
		
		//	Actually geting this request form confirm_delete.js
		if(isset($_GET['submit_delete']))
		{
			$id = $_GET['submit_delete'];
			$response = $TermOffer->delete($id);
			
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
		$Varsity = new BLLUniversity;
		$Dept = new BLLDepartment;
		$Session = new BLLSession;
		$Term = new BLLTerm;
		$Year = new BLLYear;
		$Degree = new BLLDegree;

		$TermOffer = new DALTermOffer;
		$result = $TermOffer->get();

		$post = "";
		while ($res = mysqli_fetch_assoc($result))
		 {


		 	// Get the text against all the id's.
		 	$varsity = $Varsity->getName($res["varsityId"]);
			$dept = $Dept->getName($res["deptId"]);
			$session = $Session->getSessionName($res["sessionId"]);
			$term = $Term->getTerm($res["termId"]);
			$year = $Year->getYear($res["yearId"]);
			$degree = $Degree->getDegree($res["degreeId"]);

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
			$post.= '<td>'.$varsity.'</td>';
			$post.= '<td>'.$session.'</td>';
			$post.= '<td>'.$year.' - '.$term.'</td>';
			$post.= '<td>'.$status.'</td>';
;

			$post.= '<td class="text-right"><button class="btn btn-link" id="btnEdit'.$res["id"].'" onclick="EditTermOffer('.$res["id"].','.$res["yearId"].','.$res["termId"].','.$res["varsityId"].','.$res["deptId"].','.$res["degreeId"].','.$res["sessionId"].')">Edit</button></td>';
			$post.= '<td class="text-right"><button id="delete_btn" class="btn btn-link" onclick="delete_btn_click('.$res['id'].',\'/se/dashboard/bll/bll.termoffer.php\')">Delete</button></td>';
			$post.= '<td style="display: none" id="row_id'.$res["id"].'">'.$res["id"].'</td>';
		 	$post.= '</tr>';

		 }
		 return $post;
	}

}

?>
