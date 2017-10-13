<?php

include_once($_SERVER['DOCUMENT_ROOT'].'/se/user/admin/dal/dal.assigntabulator.php');



// To activate the constructior crating an object. 
$bllAssignTabulator = new BLLAssignTabulator;

class BLLAssignTabulator
{

	function __construct()
	{

		$dalAssignTabulator = new DALAssignTabulator;

		// Multiple insert 
		if(isset($_POST['assigntabulator']))
		{
			$userId = $_POST['tabulatorId'];

			$response = 0;
			foreach($_POST['offeredTermsId'] as $offeredTermsId)
			{
				$response = $dalAssignTabulator->insert($offeredTermsId,$userId);
			}
			if($response)
			{

				$_SESSION['message'] = "Successfully Assigned to the term(s).";
			}
			else
			{

				$_SESSION['message'] = "Can't Assign 1 or more items.";
				//echo ($response);
			}

			header('Location:'.$_SERVER['HTTP_REFERER']);
			
			exit();
		}


	}

	// Display the list 
	public function show($varsityDeptId)
	{
		$dalAssignTabulator = new DALAssignTabulator;
		$result = $dalAssignTabulator->get($varsityDeptId);

		$post = "";
		while ($res = mysqli_fetch_assoc($result))
		 {

		 	$post.= '<tr>';
			$post.= '<td>'.$res["fullName"].'</td>';
			$post.= '<td>'.$res['sessionName']."->".$res["degreeName"]."->".$res["year"]."->".$res["term"].'</td>';
			
			$post.= '<td class="text-right"><button  class="btn btn-link">Edit</button></td>';
	
		 	$post.= '</tr>';

		 }
		 return $post;
	}
	
	public function getTabulators()
	{
		$dalAssignTabulator = new DALAssignTabulator;
		$result = $dalAssignTabulator->getTabulators();
		$post = "";
		while($res = mysqli_fetch_assoc($result))
          {
              $post.= '<option value='.$res['id'].'>';
              $post.= $res['phoneNo']." ";
              $post.= $res['fullName'];
              $post.= '</option>';
          }
		return $post;
	}
	// Return courses running in the current session 
	// for a specific varistyDeptId
	public function getOfferedTerms($varsityDeptId)
	{
		$dalAssignTabulator = new DALAssignTabulator;
		$result = $dalAssignTabulator->getOfferedTerms($varsityDeptId);
		$post = "";
        while ($res = mysqli_fetch_assoc($result))
        {
          $post.= '<option value='.$res['offeredTermId'].'>';
          $post.= $res['sessionName']."->".$res['degreeName']."->".$res['year']."->".$res['term'];
          $post.= '</option>';
        }
        return $post;
	}
	
}

?>
