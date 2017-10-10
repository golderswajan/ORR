<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/se/user/admin/dal/dal.courseregistrationapproval.php');


// To activate the constructior crating an object. 
$bllCourseRegistrationApproval = new BLLCourseRegistrationApproval;

class BLLCourseRegistrationApproval
{

	function __construct()
	{
		

		$dalCourseRegistrationApproval = new DALCourseRegistrationApproval;

		if(isset($_GET['approve']))
		{
			$registeredTermId = $_GET['approve'];
			// change the field only for course co-ordinator :-)
			$response=$dalCourseRegistrationApproval->approveRegistration('approvedByHead',$registeredTermId);
			// Redirect to call page as soon as task done.
			if($response)
			{
				$_SESSION['message'] = 'Registered courses approved !';
				$_SESSION['exit'] = 'Should be exit';
			}
			else
			{

				$_SESSION['message'] = "Can't approved.";
			}

			header('Location:'.$_SERVER['HTTP_REFERER']);
			exit();
		}

		if(isset($_GET['remove']))
		{
			$registeredCourseId = $_GET['remove'];
			// change the field only for course co-ordinator :-)
			$response = $dalCourseRegistrationApproval->removeCourseRegistration($registeredCourseId);

			if($response)
			{
				$_SESSION['message'] = 'Registered course removed !';
			}
			else
			{

				$_SESSION['message'] = "Can't approved.";
			}
			// Redirect to call page as soon as task done.

			header('Location:'.$_SERVER['HTTP_REFERER']);
			
			exit();
		}

		
		
	}
	// Display the list of registered course grouped by year-term
	public function show($sessionSelected,$degreeSelected,$yearSelected,$termSelected,$varsityDeptId)
	{
		$dalCourseRegistrationApproval = new DALCourseRegistrationApproval;
		$result = $dalCourseRegistrationApproval->getRegisteredStudents($sessionSelected,$degreeSelected,$yearSelected,$termSelected,$varsityDeptId);

		$data = "";
		while ($res = mysqli_fetch_assoc($result))
		 {	
		    $data.= '<tr>';
		    $data.= '<td>'.$res['studentId'].'</td>';
		    $data.= '<td>'.$res['fullName'].'</td>';

		    $totalCredit = $dalCourseRegistrationApproval->getRegisteredCourses($res['registeredTermId']);
		    $credit = 0;
		    while ($credits = mysqli_fetch_assoc($totalCredit))
		    {
		    	$credit += $credits['credit'];
		    }
		    $data.= '<td>'.$credit.'</td>';

		    $data.= '<td><a target="_blank" href="courseregistrationedit.php?edit='.$res['registeredTermId'].'">Edit/Details</a></td>';
		    $data.= '<td><a href="bll/bll.courseregistrationapproval.php?approve='.$res['registeredTermId'].'">Approve</a></td>';
		    $data.= '</tr>';


		 }
		 echo $data;
	}

	public function getRegisteredCourses($registeredTermId)
	{
		$dalCourseRegistrationApproval = new DALCourseRegistrationApproval;
		$result = $dalCourseRegistrationApproval->getRegisteredCourses($registeredTermId);

		$data = "";
		$credit = 0;
		while ($res = mysqli_fetch_assoc($result))
		 {	
		    $data.= '<tr>';
		    $data.= '<td>'.$res['prefix'].$res['courseNo'].'</td>';
		    $data.= '<td>'.$res['courseTitle'].'</td>';
		    $data.= '<td>'.$res['credit'].'</td>';
		    $credit += $res['credit'];
		    $data.= '<td><a href="bll/bll.courseregistrationapproval.php?remove='.$res['registeredCourseId'].'">Remove</a></td>';
		    $data.= '</tr>';


		 }
		 $data.= '<tr class="h3"><td></td><td>Total Credit = </td><td>'.$credit.'</td><td></td></tr>';
		 return $data;
	}

}

?>
