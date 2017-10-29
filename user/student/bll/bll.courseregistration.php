<?php
/**
*  UNIVERSITY BUISENESS LOGIC LAYER
*  CONNECTS BETWEEN DATA ACCESS LAYER AND PRESENTATION LAYER
*/
include_once($_SERVER['DOCUMENT_ROOT'].'/se/user/student/dal/dal.courseregistration.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/se/user/student/dal/dal.termregistration.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/se/user/utility.php');

// To activate the constructior crating an object. 
$bllCourseRegistration = new BLLCourseRegistration;

class BLLCourseRegistration
{

	function __construct()
	{
		

		$dalCourseRegistration = new DALCourseRegistration;

		if(isset($_POST['submit_course_registration']))
		{

			$offeredCourseId = $_POST['offeredCourseId'];
			$studentId = $_SESSION['studentId'];
			$registeredTermId = $_POST['registeredTermId'];
			$response="";
			// Build sql in for loop and inset one by one
			for($i=0;$i<count($offeredCourseId);$i++)
			{

				$sql = "INSERT INTO `registeredcourse`(`id`, `offeredCourseId`, `registeredTermId`, `isRetakeCourse`, `approvedByCourseCoordinator`, `approvedByHead`) VALUES ('',".$offeredCourseId[$i].",".$registeredTermId.",0,0,0)";
				//echo $sql;
				$response = $dalCourseRegistration->insert($sql);
			}

			if($response)
			{
				$_SESSION['message'] = "Successfully Registered.";
			}
			else
			{
				$_SESSION['message'] = "An error occured.<br>Can't Registered.";
			}


			// Redirect to call page as soon as task done.

			header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/user/student/courseregistration.php');
			exit();
		}
		
		
	}
	// Display the list of registered course grouped by year-term
	public function show($studentId)
	{
		$dalCourseRegistration = new DALCourseRegistration;
		$result = $dalCourseRegistration->getRegisteredTerms($studentId);

		$data = "";
		while ($res = mysqli_fetch_assoc($result))
		 {	
		 	$registeredTermId = $res['registeredTermId'];
		 	$registeredTermId2yearTermId= $this->registeredTermId2yearTermId($registeredTermId);
		 	
		 	$data.= '<div id="table">';
			$data.= '<table class="table">';
		    $data.= '<thead>';
		    $data.= '<tr id="courseregistration_list_'.$registeredTermId.'">';
		    $data.= '<th colspan="2"><h3 class="text-center">'.$registeredTermId2yearTermId.'</h3></th>';
		    
		    $data.= '</tr>';
		    $data.= '<tr id="courseregistration_list_'.$registeredTermId.'">';
		    $data.= '<th >Course No</th>';
		    $data.= '<th >Course Title</th>';
		    $data.= '<th >Credit</th>';
		    $data.= '</tr>';
		    $data.= '</thead>';

		    $data.= '<tbody>';
		    $result2 = $dalCourseRegistration->getRegisteredCourse($studentId,$registeredTermId);

		    $creditTaken =0.00;
		    $creditEarned =0.00;
		    while($res2 = mysqli_fetch_assoc($result2))
		    {
		    	$yearTerm= $this->registeredCourseId2yearTermId($res2["registeredCourseId"]);

		    	$data.= '<tr>';
				$data.= '<td>'.$res2['prefix'].' '.$res2['courseNo'].'</td>';
				$data.= '<td>'.$res2['courseTitle'].'</td>';
				$data.= '<td>'.$res2['credit'].'</td>';
			 	$data.= '</tr>';

			 	$creditTaken +=  $res2['credit'];
			 	$creditEarned += $this->getCreditEarned($studentId,$res2['registeredCourseId']);
		    }
        		 	
		    $data.= '</tbody>';

		    $data.= '<tfoot>';
		    $data.= '</tfoot>';
	    	$data.= '</table>';
	    	$data.= '<hr>';
	    	$data.= '<hr>';
	    	$data.='Credit Taken in this term: '.$creditTaken;
	    	$data.='<br>Credit Earned in this term: '.$creditEarned;
	    	$data.='<br>CGPA: 000000';
	    	$data.= '<hr>';
	    	$data.= '<hr>';
	  
	    	$data.= '</table>';

		 }
		 return $data;
	}
	// Return the currentRegisteredTermId
	public function getCurrentRegisteredTerm($studentId)
	{
		$dalCourseRegistration = new DALCourseRegistration;
		$result = $dalCourseRegistration->getCurrentRegisteredTerm($studentId);

		$post = "";
		while ($res = mysqli_fetch_assoc($result))
		 {
		  $post = $res['currentRegisteredTermId'];
			
		 }
		 return $post;
	}

	// Depricated (may be)
	public function getById($id)
	{
		$dalCourseRegistration = new DALCourseRegistration;
		$result = $dalCourseRegistration->getById($id);

		$data = array();
		while ($res = mysqli_fetch_assoc($result))
		 {
			$data[] = array($res["id"]=>$res['offeredCourseId']);
			
		 }
		 return $data;
	}


	// Give the offered courses eligible for current student
	public function getOfferedCourses($studentId)
	{
		$dalCourseRegistration = new DALCourseRegistration;
		$result = $dalCourseRegistration->getOfferedCourses($studentId);

		$post = "";
		if($result)
		{
			while ($res = mysqli_fetch_assoc($result))
			 {
			  $post.= '<option value='.$res['offeredCourseId'].'>';
	          $post.= $res["prefix"].' '.$res['courseNo'];
	          $post.= ' -> '.$res["courseTitle"];
	          $post.= ' -> '.$res["credit"];
	          $post.= '</option>';
				
			 }
		}
		else
		{
			$post.="<option disable='disable'>No Course is available to register.</option>";
		}		
		
		 return $post;
	}

	// Sum of credits registered in a course
	// Calculated in registered course query.
	// No more use of this function.
	// For farther use save it
	public function getCreditRegistered($registeredCourseId)
	{
		$dalCourseRegistration = new DALCourseRegistration;
		$result = $dalCourseRegistration->getCreditRegistered($registeredCourseId);

		$data = "";
		while ($res = mysqli_fetch_assoc($result))
		 {
			$data .= $res['registeredCredit'];
		 }
		 return $data;
	}
	// Sum of credits earned in a course
	public function getCreditEarned($studentId,$registeredCourseId)
	{
		$dalCourseRegistration = new DALCourseRegistration;
		$result = $dalCourseRegistration->getCreditEarned($registeredCourseId);

		$creditEarned= 0.00;
		while ($res = mysqli_fetch_assoc($result))
		 {
			$creditEarned += $res['earnedCredit'];
		 }
		 return $creditEarned;
	}

	// registeredCourseId2yearTermId
	public function registeredCourseId2yearTermId($registeredCourseId)
	{
		$dalCourseRegistration = new DALCourseRegistration;
		$result = $dalCourseRegistration->registeredCourseId2yearTermId($registeredCourseId);

		$data = "";
		while ($res = mysqli_fetch_assoc($result))
		 {
			$data .= $res['year']." - ".$res['term'];
		 }
		 return $data;
	}

	// registeredTermId2yearTermId
	// Used termregistration version :-)
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
