<?php
/**
*  UNIVERSITY BUISENESS LOGIC LAYER
*  CONNECTS BETWEEN DATA ACCESS LAYER AND PRESENTATION LAYER
*/
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/dal/dal.courseoffer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/dal/dal.termoffer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/dal/dal.assigndept.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/bll/bll.university.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/bll/bll.department.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/bll/bll.session.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/bll/bll.year.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/bll/bll.term.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/bll/bll.degree.php');

// To activate the constructior crating an object. 
$bllCourseOffer = new BLLCourseOffer;

class BLLCourseOffer
{

	function __construct()
	{

		$dalCourseOffer = new DALCourseOffer;


		// Submit form to insert data 
		if(isset($_POST['term_select_submit']))
		{
			$offeredTermId = $_POST['term_select_submit'];
			$response = $dalCourseOffer->getById($offeredTermId);
			
			if($response)
			{
				$_SESSION['term_select_submited'] = $offeredTermId;
				$_SESSION['message'] = "Successfully Retrived.";
			}
			else
			{
				$_SESSION['message'] = "Can't Retrive Courses.";
			}


			// Redirect to call page as soon as task done.

			//header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/courseoffer.php');
			//exit();
		}
		if(isset($_POST['insert_submit_courseoffer']))
		{
			$offeredTermId = $_POST['offered_term_id'];
			$courses = $_POST['courses'];

			$response = $dalCourseOffer->insertMultiple($offeredTermId,$courses);

			if($response)
			{
				session_unset();

				$_SESSION['message'] = "Successfully Inserted.";
			}
			else
			{
				$_SESSION['message'] = "Can't Insert.";
			}

			//header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/courseoffer.php');
			//exit();
		}

		if(isset($_GET['term_select']))
		{
			$offeredTermId = $_GET['term_select'];
			$response = $dalCourseOffer->getById($offeredTermId);
			
			if($response)
			{
				$_SESSION['term_submitted'] = $offeredTermId;
				$_SESSION['message'] = "Successfully Retrived.";
			}
			else
			{
				$_SESSION['message'] = "Can't Retrive Courses.";
			}


			// Redirect to call page as soon as task done.
			//header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/courseoffer.php');
			//exit();
		}
		
		//	Actually geting this request form confirm_delete.js
		if(isset($_GET['submit_delete']))
		{
			$id = $_GET['submit_delete'];
			$response = $dalCourseOffer->delete($id);
			
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
			
			header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/courseoffer.php');
			exit();
		}

	}

	// Display the list of libraries
	public function show()
	{
		$dalCourseOffer = new DALCourseOffer;
		$result = $dalCourseOffer->get();

		$post = "";
		while ($res = mysqli_fetch_assoc($result))
		 {
		 	$post.= '<tr>';
			$post.= '<td>'.$res["name"].'</td>';
			$post.= '<td class="text-right"><button class="btn btn-link" id="btnEdit'.$res["id"].'" onclick="EditCourseOffer('.$res["id"].')">Edit</button></td>';
			$post.= '<td class="text-right"><button id="delete_btn" class="btn btn-link" onclick="delete_btn_click('.$res['id'].',\'/se/dashboard/bll/bll.courseoffer.php\')">Delete</button></td>';
			$post.= '<td style="display: none" id="row_id'.$res["id"].'">'.$res["id"].'</td>';
		 	$post.= '</tr>';

		 }
		 return $post;
	}
	
	// Give the id, will return the name/[]Name dealing with DAL.
	public function getName($id)
	{
		$dalCourseOffer = new DALCourseOffer;
		$result = $dalCourseOffer->getById($id);

		$data = "";
		while ($res = mysqli_fetch_assoc($result))
		 {
			$data.= $res["name"];
			

		 }
		 return $data;
	}
	// Show the courses in course box when submit/select a term
	public function getOfferedTermCourses($id)
	{

		$dalCourseOffer = new DALCourseOffer;
		$result = $dalCourseOffer->get();

		$post = "";
		while ($res = mysqli_fetch_assoc($result))
		 {

		 	$post.= '<option value="'.$res['id'].'">';
			$post.= $varsity;
			$post.= ' -> '.$degree;
			$post.= ' -> '.$session;
			$post.= ' -> '.$year.' - '.$term;
		 	$post.= '</option>';

		 }
		 return $post;
	}

	// Show offered term list in term selection box.
	public function offeredTermInfo()
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
		 	$varsity = $Varsity->getName($varsityId);
			$dept = $Dept->getName($deptId);
			$session = $Session->getSessionName($res["sessionId"]);
			$term = $Term->getTerm($res["termId"]);
			$year = $Year->getYear($res["yearId"]);
			$degree = $Degree->getDegree($res["degreeId"]);

		 	$post.= '<option value="'.$res['id'].'">';
			$post.= $varsity;
			$post.= ' -> '.$degree;
			$post.= ' -> '.$dept;
			$post.= ' -> '.$session;
			$post.= ' -> '.$year.' - '.$term;
		 	$post.= '</option>';

		 }
		 return $post;
	}

}

?>
