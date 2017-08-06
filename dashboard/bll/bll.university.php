<?php
/**
*  UNIVERSITY BUISENESS LOGIC LAYER
*  CONNECTS BETWEEN DATA ACCESS LAYER AND PRESENTATION LAYER
*/
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/dal/dal.university.php');

// To activate the constructior crating an object. 
$University = new BLLUniversity;

class BLLUniversity
{

	function __construct()
	{
		$University = new DALUniversity;

		if(isset($_POST['submit_insert']))
		{
			$name = $_POST['name'];
			
			$response = $University->insert($name);
			if($response)
			{
				$_SESSION['message'] = "Successfully Inserted.";
			}
			else
			{
				$_SESSION['message'] = "Can't Insert.";
			}


			// Redirect to call page as soon as task done.
			header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/university.php');
			exit();
		}
		if(isset($_POST['submit_update']))
		{
			$id = $_POST['id'];
			$name = $_POST['name'];

			$response = $University->update($id,$name);
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
			header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/university.php');
			exit();

		}
		
		//	Actually geting this request form confirm_delete.js
		if(isset($_GET['submit_delete']))
		{
			$id = $_GET['submit_delete'];
			$response = $University->delete($id);
			
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
			header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/dashboard/university.php');
			exit();
		}

	}

	// Display the list of libraries
	public function show()
	{
		$University = new DALuniversity;
		$result = $University->get();

		$post = "";
		while ($res = mysqli_fetch_assoc($result))
		 {
		 	$post.= '<tr>';
			$post.= '<td>'.$res["name"].'</td>';
			$post.= '<td><button class="btn btn-link" id="btnEdit'.$res["id"].'" onclick="EditUniversity('.$res["id"].')">Edit</button></td>';
			$post.= '<td><button id="delete_btn" class="btn btn-link" onclick="delete_btn_click('.$res['id'].',\'/se/dashboard/bll/bll.university.php\')">Delete</button></td>';
			$post.= '<td style="display: none" id="row_id'.$res["id"].'">'.$res["id"].'</td>';
		 	$post.= '</tr>';


		 }
		 return $post;
	}

}




?>
<script>
function confirmation() {
   	var txt;
    var r = confirm("Are you sure?");
    if (r == true) {
    	document.write(x);
    } else {
    	alert('thansk');
       return false;
    }
   
}
</script>