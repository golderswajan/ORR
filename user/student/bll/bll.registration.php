<?php
/**
*  UNIVERSITY BUISENESS LOGIC LAYER
*  CONNECTS BETWEEN DATA ACCESS LAYER AND PRESENTATION LAYER
*/
include_once($_SERVER['DOCUMENT_ROOT'].'/se/user/student/dal/dal.registration.php');

// To activate the constructior crating an object. 
$bllRegistration = new BLLRegistration;

class BLLRegistration
{

	function __construct()
	{
		

		$dalRegistration = new DALRegistration;

		if(isset($_POST['submit_insert']))
		{

			$offeredTermId = $_POST['offeredTermId'];

			$response = $dalRegistration->insert($studentId,$offeredTermId);

			if($response)
			{
				$_SESSION['message'] = "Successfully Inserted.";
			}
			else
			{
				$_SESSION['message'] = "Can't Insert.";
			}


			// Redirect to call page as soon as task done.

			header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/registration.php');
			exit();
		}
		if(isset($_POST['submit_update']))
		{
			$id = $_POST['id'];
			$name = $_POST['name'];

			if (ctype_space($name))
			{
				$_SESSION['message'] = "Contains spaces only.";
				header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/registration.php');
				exit();
				return false;
			}

			$response = $dalRegistration->update($id,$name);
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
			header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/registration.php');
			exit();

		}
		
	}
	// Display the list of registered term
	public function show($studentId)
	{
		$dalRegistration = new DALregistration;
		$result = $dalRegistration->getRegisteredTerm($studentId);

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
		$dalRegistration = new DALregistration;
		$result = $dalRegistration->getRegisteredTerm($studentId);

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
		$dalRegistration = new DALregistration;
		$result = $dalRegistration->getRegisteredTerm($studentId);

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
		$dalRegistration = new DALRegistration;
		$result = $dalRegistration->getById($id);

		$data = array();
		while ($res = mysqli_fetch_assoc($result))
		 {
			$data[] = array($res["id"]=>$res['offeredTermId']);
			
		 }
		 return $data;
	}

}

?>
