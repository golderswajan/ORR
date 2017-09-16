<?php
/**
*  UNIVERSITY BUISENESS LOGIC LAYER
*  CONNECTS BETWEEN DATA ACCESS LAYER AND PRESENTATION LAYER
*/
include_once($_SERVER['DOCUMENT_ROOT'].'/se/user/student/dal/dal.termregistration.php');

// To activate the constructior crating an object. 
$bllTermRegistration = new BLLTermRegistration;

class BLLTermRegistration
{

	function __construct()
	{
		

		$dalTermRegistration = new DALTermRegistration;

		if(isset($_POST['submit_insert']))
		{

			$offeredTermId = $_POST['offeredTermId'];

			$response = $dalTermRegistration->insert($studentId,$offeredTermId);

			if($response)
			{
				$_SESSION['message'] = "Successfully Inserted.";
			}
			else
			{
				$_SESSION['message'] = "Can't Insert.";
			}


			// Redirect to call page as soon as task done.

			header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/termregistration.php');
			exit();
		}
		if(isset($_POST['submit_update']))
		{
			$id = $_POST['id'];
			$name = $_POST['name'];

			if (ctype_space($name))
			{
				$_SESSION['message'] = "Contains spaces only.";
				header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/termregistration.php');
				exit();
				return false;
			}

			$response = $dalTermRegistration->update($id,$name);
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
			header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/termregistration.php');
			exit();

		}
		
	}
	// Display the list of registered term
	public function show($studentId)
	{
		$dalTermRegistration = new DALTermRegistration;
		$result = $dalTermRegistration->getRegisteredTerm($studentId);

		$post = "";
		while ($res = mysqli_fetch_assoc($result))
		 {
		 	$post.= '<tr>';
			$post.= '<td>'.$res["id"].'</td>';
			$post.= '<td>'.$res["offeredTermId"].'</td>';
			$post.= '<td>'.$res["studentId"].'</td>';
		 	$post.= '</tr>';

		 }
		 return $post;
	}

	// Get the latest registered term id
	public function getCurrentRegisteredTermId($studentId)
	{
		$dalTermRegistration = new DALTermRegistration;
		$result = $dalTermRegistration->getRegisteredTerm($studentId);

		$id = "";
		while ($res = mysqli_fetch_assoc($result))
		 {
		 	$id = $res['id'];

		 }
		 return $id;
	}

	// Get all registered termId-> offeredTermId
	public function getRegisteredTerms($studentId)
	{
		$dalTermRegistration = new DALTermRegistration;
		$result = $dalTermRegistration->getRegisteredTerm($studentId);

		$terms = array();
		while ($res = mysqli_fetch_assoc($result))
		 {
		 	$terms[] = array($res['id'] => $res['offeredTermId']);

		 }
		 return $terms;
	}
	
	
	// Give the id, will return the name/[]Name dealing with DAL.
	public function getById($id)
	{
		$dalTermRegistration = new DALTermRegistration;
		$result = $dalTermRegistration->getById($id);

		$data = array();
		while ($res = mysqli_fetch_assoc($result))
		 {
			$data[] = array($res["id"]=>$res['offeredTermId']);
			
		 }
		 return $data;
	}


	// Give the offered terms eligible for current student
	public function getOfferedTerms($studentId)
	{
		$dalTermRegistration = new DALTermRegistration;
		$result = $dalTermRegistration->getOfferedTerms($studentId);

		$data = "";
		while ($res = mysqli_fetch_assoc($result))
		 {
			$data = "";
			
		 }
		 return $data;
	}

}

?>
