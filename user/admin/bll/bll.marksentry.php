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

		// After submission of data grid
//----------- Very Very Important and never remove the comments-----------
		if(isset($_POST['marksentry']))
		{
			// Each row data 
			$registeredCourseArray = array();
			$marksArray = array();
			$sectionArray = array();
			$numSections =0;

			foreach ($_POST['registeredCourseId'] as $registeredCourseId)
			{
				$registeredCourseArray[] += $registeredCourseId;

				//echo $registeredCourseId;

				// Count mark sections
				$markSectionsCount = $dalMarksEntry->getMarkSectionsCount($registeredCourseId);
				while ($res = mysqli_fetch_assoc($markSectionsCount))
				{
					$numSections = $res['numSections'];
				}

				// sectionId array
				$sectionId = $dalMarksEntry->getMarkSectionsByRegisteredCourseId($registeredCourseId);
				while ($res = mysqli_fetch_assoc($sectionId))
				{
					$sectionArray[] .= $res['id'];
				}
			}
			foreach ($_POST['sectionMark'] as $sectionMark)
			{
				$marksArray[] += $sectionMark;
				//echo $sectionMark;
			}

			 // echo "numRegisteredCourseArray=".sizeof($registeredCourseArray)."<br>";
			 // echo "numSectionsArray=".sizeof($marksArray)."<br>";
			 // echo "sectionArray=".sizeof($sectionArray)."<br>";
			 // var_dump($sectionArray);
			 // echo "numSections=".$numSections."<br>";
			// The actual data entry
			for($i=0,$j=0;$i<sizeof($registeredCourseArray);$i++,$j=$j+$numSections)
			{
				//echo $registeredCourseArray[$i]."<br>";
				$totalMarks =0;

				// Precheck if total marks is greater than 100
				for($k=0;$k<$numSections;$k++)
				{
					$mark = intval($marksArray[$j+$k]);
					//echo $mark."sectionMark <br>";
					$totalMarks += $mark;
				}

				// Insert section wise marks
				if($totalMarks>100)
				{
					$_SESSION['message'] .= "Can't inset section-wise marks. <br>";
				}
				else
				{
					for($k=0;$k<$numSections;$k++)
					{
						$mark = intval($marksArray[$j+$k]);
						//echo $mark."sectionMark <br>";
						$marksectionResult = $dalMarksEntry->updateSectionMarks($registeredCourseArray[$i],$sectionArray[$j+$k],$mark);
						///echo $marksectionResult;
					}
				}

				
				//echo $totalMarks."<br>";

				// Insert final marks
				if($totalMarks>100)
				{
					$_SESSION['message'] .= "Can't Insert Total marks. <br>Total marks exceeds 100.<br>";
				}
				else
				{
					$totalMarksResult = $dalMarksEntry->updateTotalMarks($registeredCourseArray[$i],$totalMarks);
				}
				
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

	// Print data grid CRUD according to registered courses
	// If student is not registered why should print empty boxes? where these data goes?
	//
	public function getRegisteredCourses($sessionId,$degreeId,$yearId,$termId,$offeredCourseId,$varsityDeptId)
	{
		$dalMarksEntry = new DALMarksEntry;
		// get that courseId which have students registered
		$result = $dalMarksEntry->getRegisteredCourses($sessionId,$degreeId,$yearId,$termId,$offeredCourseId,$varsityDeptId);

		$data = "";
		$i=1;
		while ($res = mysqli_fetch_assoc($result))
		{
			$registeredCourseId = $res['registeredCourseId'];
			$data.= '<tr id="'.$registeredCourseId.'">';
			$data.= '<td>'.$i++;
			$data.= '<input type="text" style="display:none;" value="'.$registeredCourseId.'" name="registeredCourseId[]" required>';
			$data.= '</td>';
			$data.= '<td name="'.$res['studentId'].'">'.$res['studentId'];
			$data.= '<input type="text" style="display:none;" value="'.$res['studentId'].'" name="studentId[]" required>';
			$data.= '</td>';
		

			$headers = $dalMarksEntry->getMarkSectionsByRegisteredCourseId($registeredCourseId);

			while($header = mysqli_fetch_assoc($headers))
			{
				// max = sectionPercentage
				// name = sectionId
			    $data.='<td><input type="number" max="'.$header['percentage'].'" min="0" class="form-control" name="sectionMark[]" required></td>';
			}

			$data.= '</tr>';
		}
		return $data;

	}

	// marks entry table header except serial and studnetId
	public function getHeaders($sessionId,$degreeId,$yearId,$termId,$offeredCourseId,$varsityDeptId)
	{
		$dalMarksEntry = new DALMarksEntry;
		// get that courseId which have students registered
		$result = $dalMarksEntry->getRegisteredCourses($sessionId,$degreeId,$yearId,$termId,$offeredCourseId,$varsityDeptId);
		
		$data = "";
		while ($res = mysqli_fetch_assoc($result))
		{
			$registeredCourseId = $res['registeredCourseId'];

			$result = $dalMarksEntry->getMarkSectionsByRegisteredCourseId($registeredCourseId);
			while ($res = mysqli_fetch_assoc($result))
			{
				$data.= '<td>'.$res['name'].'</td>';
			}
			// I need only one registeredCourseId
			// So terminate the loop 
			break;
		}

		return $data;

	}

}

?>
