<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/se/user/admin/dal/dal.courseregistrationapproval.php');


// To activate the constructior crating an object. 
$bllCourseRegistrationApproval = new BLLCourseRegistrationApproval;

class BLLCourseRegistrationApproval
{

	function __construct()
	{
		

		$dalCourseRegistrationApproval = new DALCourseRegistrationApproval;

		if(isset($_GET['submitCollectedData']))
		{
			$sessionSelected =  $_GET['sessionSelected'];
			$degreeSelected =  $_GET['degreeSelected'];
			$yearSelected =  $_GET['yearSelected'];
			$termSelected =  $_GET['termSelected'];
			$varsityDeptId =  $_GET['varsityDeptId'];

			//echo $sessionSelected."->".$degreeSelected."->".$yearSelected."->".$termSelected."->".$varsityDeptId;

			// Redirect to call page as soon as task done.

			header('Location:'.$_SERVER['DOCUMENT_ROOT'].'/se/user/admin/courseregistrationapproval.php');
			exit();
		}
		
		
	}
	// Display the list of registered course grouped by year-term
	public function show($adminId)
	{
		$dalCourseRegistrationApproval = new DALCourseRegistrationApproval;
		$result = $dalCourseRegistrationApproval->getRegisteredTerms($adminId);

		$data = "";
		while ($res = mysqli_fetch_assoc($result))
		 {	
		 	$registeredTermId = $res['registeredTermId'];
		 	$registeredTermId2yearTermId= $this->registeredTermId2yearTermId($registeredTermId);
		 	
		 	$data.= '<div id="table">';
			$data.= '<table class="table">';
		    $data.= '<thead>';
		    $data.= '<tr id="courseregistrationapproval_list_'.$registeredTermId.'">';
		    $data.= '<th colspan="2"><h3 class="text-center">'.$registeredTermId2yearTermId.'</h3></th>';
		    
		    $data.= '</tr>';
		    $data.= '<tr id="courseregistrationapproval_list_'.$registeredTermId.'">';
		    $data.= '<th >Course No</th>';
		    $data.= '<th >Course Title</th>';
		    $data.= '<th >Credit</th>';
		    $data.= '</tr>';
		    $data.= '</thead>';

		    $data.= '<tbody>';
		    $result2 = $dalCourseRegistrationApproval->getRegisteredCourse($adminId,$registeredTermId);

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
			 	$creditEarned += $this->getCreditEarned($adminId,$res2['registeredCourseId']);
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
	public function getCurrentRegisteredTerm($adminId)
	{
		$dalCourseRegistrationApproval = new DALCourseRegistrationApproval;
		$result = $dalCourseRegistrationApproval->getCurrentRegisteredTerm($adminId);

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
		$dalCourseRegistrationApproval = new DALCourseRegistrationApproval;
		$result = $dalCourseRegistrationApproval->getById($id);

		$data = array();
		while ($res = mysqli_fetch_assoc($result))
		 {
			$data[] = array($res["id"]=>$res['offeredCourseId']);
			
		 }
		 return $data;
	}


	// Give the offered courses eligible for current admin
	public function getOfferedCourses($adminId)
	{
		$dalCourseRegistrationApproval = new DALCourseRegistrationApproval;
		$result = $dalCourseRegistrationApproval->getOfferedCourses($adminId);

		$post = "";
		
		while ($res = mysqli_fetch_assoc($result))
		 {
		  $post.= '<option value='.$res['offeredCourseId'].'>';
          $post.= $res["prefix"].' '.$res['courseNo'];
          $post.= ' -> '.$res["courseTitle"];
          $post.= ' -> '.$res["credit"];
          $post.= '</option>';
			
		 }
		 return $post;
	}

	// Sum of credits registered in a course
	// Calculated in registered course query.
	// No more use of this function.
	// For farther use save it
	public function getCreditRegistered($registeredCourseId)
	{
		$dalCourseRegistrationApproval = new DALCourseRegistrationApproval;
		$result = $dalCourseRegistrationApproval->getCreditRegistered($registeredCourseId);

		$data = "";
		while ($res = mysqli_fetch_assoc($result))
		 {
			$data .= $res['registeredCredit'];
		 }
		 return $data;
	}
	// Sum of credits earned in a course
	public function getCreditEarned($adminId,$registeredCourseId)
	{
		$dalCourseRegistrationApproval = new DALCourseRegistrationApproval;
		$result = $dalCourseRegistrationApproval->getCreditEarned($registeredCourseId);

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
		$dalCourseRegistrationApproval = new DALCourseRegistrationApproval;
		$result = $dalCourseRegistrationApproval->registeredCourseId2yearTermId($registeredCourseId);

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
