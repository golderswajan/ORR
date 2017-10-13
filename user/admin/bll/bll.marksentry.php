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
			echo $response;
			// Redirect to call page as soon as task done.
			if($response)
			{
				$_SESSION['message'] = $response;
			}
			header('Location:'.$_SERVER['HTTP_REFERER']);
			exit();
		}

		if(isset($_POST['marksentry']))
		{
			echo($_POST['marksentry']);
			echo($_POST['5']);
			echo($_POST['6']);
			echo($_POST['7']);
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
		$i=1;
		while ($res = mysqli_fetch_assoc($result))
		{
			$registeredCourseId = $res['registeredCourseId'];
			$data.= '<tr id="'.$registeredCourseId.'">';
			$data.= '<td>'.$i++.'</td>';
			$data.= '<td name="'.$res['studentId'].'">'.$res['studentId'].'</td>';

			$headers = $dalMarksEntry->getHeaders($offeredCourseId);

			while($header = mysqli_fetch_assoc($headers))
			{
				// max = sectionPercentage
				// name = sectionId
			    $data.='<td><input type="number" max="'.$header['percentage'].'" min="0" class="form-control" name="'.$header['sectionId'].'"></td>';
			}

			$data.= '</tr>';
		}
		return $data;

	}

	// marks entry table header except serial and studnetId
	public function getHeaders($offeredCourseId)
	{
		$dalMarksEntry = new DALMarksEntry;
		$result = $dalMarksEntry->getHeaders($offeredCourseId);

		$data = "";
		while ($res = mysqli_fetch_assoc($result))
		{
			$data.= '<td>'.$res['sectionName'].'</td>';
		}
		return $data;

	}

}

?>
