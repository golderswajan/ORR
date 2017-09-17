<?php
/**
*  UNIVERSITY BUISENESS LOGIC LAYER
*  CONNECTS BETWEEN DATA ACCESS LAYER AND PRESENTATION LAYER
*/

include_once($_SERVER['DOCUMENT_ROOT'].'/se/user/student/dal/dal.termregistration.php');
include_once('../utility.php');

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
			$studentId = $_SESSION['studentId'];
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

			header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/user/student/termregistration.php');
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
		 	// Get registered credit
		 	$registeredCredit = $this->getCreditRegistered($res["id"]);
		 	if($registeredCredit==null)
		 	{
		 		$registeredCredit = 0;
		 	}

		 	// Get earned credit
		 	$earnedCredit = $this->getCreditEarned($res["id"]);
		 	if($earnedCredit==null)
		 	{
		 		$earnedCredit = 0;
		 	}

		 	$yearTerm = $this->registeredTermId2yearTermId($res["id"]);
		 	$post.= '<tr>';
			$post.= '<td>'.$yearTerm.'</td>';
			$post.= '<td>'.$registeredCredit.'</td>';
			$post.= '<td>'.$earnedCredit.'</td>';
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
	public function getOfferedTerms($studentId,$varsityDeptId)
	{
		$dalTermRegistration = new DALTermRegistration;
		$result = $dalTermRegistration->getOfferedTerms($studentId,$varsityDeptId);

		$data = array();
		while ($res = mysqli_fetch_assoc($result))
		 {
			$data += array('offeredTermId'=>$res['id']);
			$data += array('degreeId'=>$res['degreeId']);
			$data += array('sessionId'=>$res['sessionId']);
			$data += array('yearId'=>$res['yearId']);
			$data += array('termId'=>$res['termId']);
			$data += array('varsityDeptId'=>$res['varsityDeptId']);
			
		 }
		 return $data;
	}

	// Sum of credits registered in a term
	public function getCreditRegistered($registeredTermId)
	{
		$dalTermRegistration = new DALTermRegistration;
		$result = $dalTermRegistration->getCreditRegistered($registeredTermId);

		$data = "";
		while ($res = mysqli_fetch_assoc($result))
		 {
			$data .= $res['registeredCredit'];
		 }
		 return $data;
	}
	// Sum of credits earned in a term
	public function getCreditEarned($registeredTermId)
	{
		$dalTermRegistration = new DALTermRegistration;
		$result = $dalTermRegistration->getCreditEarned($registeredTermId);

		$data = "";
		while ($res = mysqli_fetch_assoc($result))
		 {
			$data .= $res['registeredCredit'];
		 }
		 return $data;
	}

	// registeredTermId2yearTermId
	public function registeredTermId2yearTermId($registeredTermId)
	{
		$dalTermRegistration = new DALTermRegistration;
		$result = $dalTermRegistration->registeredTermId2yearTermId($registeredTermId);

		$data = "";
		while ($res = mysqli_fetch_assoc($result))
		 {
			$data .= $res['year']." - ".$res['term'];
		 }
		 return $data;
	}

}

?>
