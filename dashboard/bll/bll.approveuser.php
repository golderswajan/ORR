<?php
/**
*  UNIVERSITY BUISENESS LOGIC LAYER
*  CONNECTS BETWEEN DATA ACCESS LAYER AND PRESENTATION LAYER
*/
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/dal/dal.approveuser.php');

// To activate the constructior crating an object. 
$bllApproveUser = new BLLApproveUser;

class BLLApproveUser
{

	function __construct()
	{

		$dalApproveUser = new DALApproveUser;
		$response = "";
		if(isset($_POST['approve']))
		{
			$checkbox = $_POST['checkbox'];

			foreach ($checkbox as $id) {
				// update one by one.
				$response = $dalApproveUser->approve($id);
			}

			// Redirect to call page as soon as task done.
			if($response)
			{
				$_SESSION['message'] = "User(s) Activated.";
			}
			else 
			{
				$_SESSION['message'] = "Can't Activate User(s)";
			}

			// Redirect to call page as soon as task done.
			header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/approveuser.php');
			exit();
		}

		if(isset($_POST['approveAll']))
		{
			$response = $dalApproveUser->approveAll();
			
			if($response)
			{
				$_SESSION['message'] = "User(s) Activated.";
			}
			else 
			{
				$_SESSION['message'] = "Can't Activate User(s)";
			}
			// Redirect to call page as soon as task done.
			header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/approveuser.php');
			exit();
		}

	}

	// Display the list of inactive users
	public function show()
	{
		$dalApproveUser = new DALApproveUser;
		$result = $dalApproveUser->get();

		$post = "";
		while ($res = mysqli_fetch_assoc($result))
		 {
		 	$post.= '<tr>';
			$post.= '<td>'.$res["userName"].'</td>';
			$post.= '<td>'.$res["email"].'</td>';
			$post.= '<td>'.$res["roleId"].'</td>';

			$post.= '<td class="text-right"><input type="checkbox" name="checkbox[]" value='.$res['id'].'></td>';
			
			$post.= '<td style="display: none" id="row_id'.$res["id"].'">'.$res["id"].'</td>';
		 	$post.= '</tr>';

		 }
		 return $post;
	}

}

?>
