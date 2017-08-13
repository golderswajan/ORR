<?php
/**
*  UNIVERSITY BUISENESS LOGIC LAYER
*  CONNECTS BETWEEN DATA ACCESS LAYER AND PRESENTATION LAYER
*/
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/dal/dal.courseoffer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/dal/dal.termoffer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/bll/bll.university.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/bll/bll.department.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/bll/bll.session.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/bll/bll.year.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/bll/bll.term.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/bll/bll.degree.php');

// To activate the constructior crating an object. 
$CourseOffer = new BLLCourseOffer;

class BLLCourseOffer
{

	function __construct()
	{

		$CourseOffer = new DALCourseOffer;

		if(isset($_GET['term_select']))
		{
			$offered_term_id = $_GET['term_select'];
			$response = $CourseOffer->getById($offered_term_id);
			
			if($response)
			{
				$_SESSION['term_submitted'] = $offered_term_id;
				$_SESSION['message'] = "Successfully Retrived.";
			}
			else
			{
				$_SESSION['message'] = "Can't Retrive Courses.";
			}


			// Redirect to call page as soon as task done.

			header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/courseoffer.php');
			exit();
		}
		// Submit form to insert data 
		if(isset($_GET['term_select_submit']))
		{
			$offered_term_id = $_GET['term_select_submit'];
			$response = $CourseOffer->getById($offered_term_id);
			
			if($response)
			{
				$_SESSION['term_select_submited'] = $offered_term_id;
				$_SESSION['message'] = "Successfully Retrived.";
			}
			else
			{
				$_SESSION['message'] = "Can't Retrive Courses.";
			}


			// Redirect to call page as soon as task done.

			header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/courseoffer.php');
			exit();
		}
		
		//	Actually geting this request form confirm_delete.js
		if(isset($_GET['submit_delete']))
		{
			$id = $_GET['submit_delete'];
			$response = $CourseOffer->delete($id);
			
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
		$CourseOffer = new DALcourseoffer;
		$result = $CourseOffer->get();

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
		$CourseOffer = new DALcourseoffer;
		$result = $CourseOffer->getById($id);

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

		$CourseOffer = new DALCourseOffer;
		$result = $CourseOffer->get();

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


		 	// Get the text against all the id's.
		 	$varsity = $Varsity->getName($res["varsityId"]);
			$dept = $Dept->getName($res["deptId"]);
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
