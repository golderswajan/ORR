<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/se/user/admin/dal/dal.marksentry.php');


// To activate the constructior crating an object. 
$bllMarksEntry = new BLLMarksEntry;

class BLLMarksEntry
{

	function __construct()
	{
		

		$dalMarksEntry = new DALMarksEntry;

		if(isset($_GET['load_mark_table']))
		{
			$sessionSelected =  $_GET['sessionSelected'];
	        $degreeSelected =  $_GET['degreeSelected'];
	        $yearSelected =  $_GET['yearSelected'];
	        $termSelected =  $_GET['termSelected'];
	        $offeredCourseSelected =  $_GET['offeredCourseSelected'];
	        $varsityDeptId =  $_GET['varsityDeptId'];

	        $sectionSelected[] = array();
	        foreach($_GET['check_list'] as $check)
	        {
            	$sectionSelected[] =  $check; 
        	}
        	$response="";
        	// DANGER !!!
        	// SO MANY QUARIES INSIDE 
        	// BE CAREFUL

			$response=$dalMarksEntry->createMarksField($sessionSelected,$degreeSelected,$yearSelected,$termSelected,$offeredCourseSelected,$sectionSelected,$varsityDeptId);
			// Redirect to call page as soon as task done.
			if($response)
			{
				$_SESSION['message'] = $response;
			}
			else
			{

				$_SESSION['message'] = "Can't create marks field.";
			}

			header('Location:'.$_SERVER['HTTP_REFERER']);
			exit();
		}

	}
	// Display the list of registered course grouped by year-term
	public function show($sessionSelected,$degreeSelected,$yearSelected,$termSelected,$varsityDeptId)
	{
		$dalMarksEntry = new DALMarksEntry;
		$result = $dalMarksEntry->getRegisteredStudents($sessionSelected,$degreeSelected,$yearSelected,$termSelected,$varsityDeptId);

		$data = "";
		while ($res = mysqli_fetch_assoc($result))
		 {	
		 }
		 echo $data;
	}

	public function getRegisteredCourses($sessionId,$degreeId,$yearId,$termId,$offeredCourseId,$varsityDeptId)
	{
		$dalMarksEntry = new DALMarksEntry;
		$result = $dalMarksEntry->getRegisteredCourses($sessionId,$degreeId,$yearId,$termId,$offeredCourseId,$varsityDeptId);

		$data = "";
		while ($res = mysqli_fetch_assoc($result))
		{
			$registeredCourseId;
			$data.= '<tr>';
			$data.= '<td>'.$res['studentId'].'</td>';
			$data.= '<td>'.$res['registeredCourseId'].'</td>';
			$data.= '</tr>';
		}
		return $data;

	}

}

?>
