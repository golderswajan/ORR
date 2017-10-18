<?php
/**
*  UNIVERSITY BUISENESS LOGIC LAYER
*  CONNECTS BETWEEN DATA ACCESS LAYER AND PRESENTATION LAYER
*/

include_once($_SERVER['DOCUMENT_ROOT'].'/se/user/student/dal/dal.result.php');
include_once('../utility.php');

// To activate the constructior crating an object. 
$bllResult = new BLLResult;
$totalRegisteredCreditHours = 0; 
$totalGradePoints = 0; // GP
$totalEarnedCreditHours = 0; //CH
$totalEarnedCreditPoints = 0; // GP*CH

class BLLResult
{

	function __construct()
	{
		
		$dalResult = new DALResult;
	}
	// Display the result
	public function show($registeredTermId)
	{
		$dalResult = new DALResult;
		$result = $dalResult->getResult($registeredTermId);

		$post = "";
		while ($res = mysqli_fetch_assoc($result))
		 {
		 	// Calculations using conversion
		 	$letterGrade = $this->letterGrade($res['totalMark']);
		 	$gradePoint = $this->gradePoint($res['totalMark']);
		 	$earnedCredit = 0;
		 	if($gradePoint==0)
		 	{
		 		$earnedCredit = 0.00;
		 	}
		 	else 
		 	{
		 		$earnedCredit = $res['credit'];
		 	}

		 	$earnedCreditPoints = $earnedCredit * $gradePoint;

		 	$GLOBALS['totalEarnedCreditPoints'] += $earnedCreditPoints;
		 	$GLOBALS['totalRegisteredCreditHours'] += $res['credit'];
		 	$GLOBALS['totalGradePoints'] += $gradePoint;
		 	$GLOBALS['totalEarnedCreditHours'] += $earnedCredit;

		 	$remarks = $this->remarks($res['remarks']);

		 	$post.= '<tr>';
			$post.= '<td>'.$res['prefix']." ".$res['courseNo'].'</td>';
			$post.= '<td>'.$res['courseTitle'].'</td>';
			$post.= '<td>'.number_format($res['credit'],2).'</td>';
			$post.= '<td>'.$letterGrade.'</td>';
			$post.= '<td>'.number_format($gradePoint,2).'</td>';
			$post.= '<td>'.number_format($earnedCredit,2).'</td>';
			$post.= '<td>'.number_format($earnedCreditPoints,2).'</td>';
			$post.= '<td>'.$remarks.'</td>';

		 	$post.= '</tr>';

		 }
		 $total = "";
		 $total .= '<tr>';
		 $total .= '<td></td>';
		 $total .= '<td>Total = </td>';
		 $total .= '<td>'.$GLOBALS['totalRegisteredCreditHours'].'</td>';
		 $total .= '<td></td>';
		 $total .= '<td>'.$GLOBALS['totalGradePoints'].'</td>';
		 $total .= '<td>'.$GLOBALS['totalEarnedCreditHours'].'</td>';
		 $total .= '<td>'.$GLOBALS['totalEarnedCreditPoints'].'</td>';
		 $total .= '<td></td>';
		 $total .= '</tr>';

		 return $post.$total;
	}
	// Display the result header
	public function getHeaderInfo($studentId,$varsityDeptId,$registeredTermId)
	{
		$dalResult = new DALResult;
		$result = $dalResult->getHeaderInfo($studentId,$varsityDeptId,$registeredTermId);
	 	return $result;

	}
	// Display the result footer
	public function showFooter($registeredTermId)
	{
		$dalResult = new DALResult;
		// Get registered credit
	 	$post = "";

	 	$totalEarnedCreditPoints = $GLOBALS['totalEarnedCreditPoints'];
	 	$totalEarnedCreditHours = $GLOBALS['totalEarnedCreditHours'];
	 	$totalRegisteredCreditHours = $GLOBALS['totalRegisteredCreditHours'];

	 	// TGPA = TCP/TCH
	 	$TGPA = $totalEarnedCreditPoints/$totalEarnedCreditHours;

	 	$post = "";
	 	$post = "<tr><td class='h4'><u>Term Assesment</u></td><td></td><td></td><td></td></tr>";
	 	// Earned Credit Hours TCH
	 	$post .= '<tr>';
	 	$post.='<td>Total Earned Credit Hours in Term (TCH) =</td><td>'.$totalEarnedCreditHours.'<td>';
	 	$post.='<td>&nbsp;&nbsp;&nbsp;<td>';
	 	$post.='<td>Total Earned Credit Hours All Previous Terms (S) =</td><td>0<td>';
	 	$post.='</tr>';

	 	// Registered
	 	$post .= '<tr>';
	 	$post.='<td>Total Registered Credit Hours in Term =</td><td>'.$totalRegisteredCreditHours.'<td>';
	 	$post.='<td>&nbsp;&nbsp;&nbsp;<td>';

	 	$post.='<td>Total Registered Credit Points All Previous Terms (S) =</td><td>0<td>';
	 	$post.='</tr>';

	 	// Total Earned Credit Points(TCP)
	 	$post .= '<tr>';
	 	$post.='<td>Total Earned Credit Points in Term (TCP) =</td><td>'.$totalEarnedCreditPoints.'<td>';
	 	$post.='<td>&nbsp;&nbsp;&nbsp;<td>';

	 	$post.='<td>Total Earned Credit Hours including this Term (CCH) =</td><td>0<td>';
	 	$post.='</tr>';

	 	// TGPA = TCP/TCH
	 	$post .= '<tr>';
	 	$post.='<td>TGPA = TCP/TCH =</td><td>'.$TGPA.'<td>';
	 	$post.='<td>&nbsp;&nbsp;&nbsp;<td>';

	 	$post.='<td>Total Earned Credit Points including this Term  (CCP) =</td><td>0<td>';
	 	$post.='</tr>';

		return $post;
	}

	// Get the latest registered term id
	public function getCurrentRegisteredTermId($studentId)
	{
		$dalResult = new DALResult;
		$result = $dalResult->getRegisteredTerm($studentId);

		$id = "";
		while ($res = mysqli_fetch_assoc($result))
		 {
		 	$id = $res['id'];

		 }
		 return $id;
	}

	// Get all registered termId
	public function getRegisteredTerms($studentId,$varsityDeptId)
	{
		$dalResult = new DALResult;
		$result = $dalResult->getRegisteredTerms($studentId,$varsityDeptId);
		$option = "";
		while ($res = mysqli_fetch_assoc($result))
		{
			$option .= '<option value="'.$res['registeredTermId'].'">';
			$option .= $res['degreeName']."->".$res['sessionName']."->".$res['year']."->".$res['term'];
			$option .= '</option>';

		}

		 return $option;
	}
	
	// Sum of credits registered in a term
	public function getCreditRegistered($registeredTermId)
	{
		$dalResult = new DALResult;
		$result = $dalResult->getCreditRegistered($registeredTermId);

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
		$dalResult = new DALResult;
		$result = $dalResult->getCreditEarned($registeredTermId);

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
		$dalResult = new DALResult;
		$result = $dalResult->registeredTermId2yearTermId($registeredTermId);

		$data = "";
		while ($res = mysqli_fetch_assoc($result))
		 {
			$data .= $res['year']." - ".$res['term'];
		 }
		 return $data;
	}

//----------- Conversions-------------------------------------------------
 	
 	public function letterGrade($totalMarks)
 	{
 		$grade = "";

 		switch ($totalMarks)
 		{
 			case $totalMarks>=80:
 				$grade = "A+";
 				break;
 			case $totalMarks>75:
 				$grade = "A";
 				break;
 			case $totalMarks>=70:
 				$grade = "A-";
 				break;
 			case $totalMarks>=65:
 				$grade = "B+";
 				break;
 			case $totalMarks>=60:
 				$grade = "B";
 				break;
 			case $totalMarks>=55:
 				$grade = "B-";
 				break;
 			case $totalMarks>=50:
 				$grade = "C+";
 				break;
 			case $totalMarks>=45:
 				$grade = "C";
 				break;
 			case $totalMarks>=40:
 				$grade = "D";
 				break;
 			default:
 				$grade = "F";
 				break;
 		}
 		return $grade;
 	}

 	public function gradePoint($totalMarks)
 	{
 		$grade = 0.00;

 		switch ($totalMarks)
 		{
 			case $totalMarks>=80:
 				$grade = 4.00;
 				break;
 			case $totalMarks>75:
 				$grade = 3.75;
 				break;
 			case $totalMarks>=70:
 				$grade = 3.50;
 				break;
 			case $totalMarks>=65:
 				$grade = 3.25;
 				break;
 			case $totalMarks>=60:
 				$grade = 3.00;
 				break;
 			case $totalMarks>=55:
 				$grade = 2.75;
 				break;
 			case $totalMarks>=50:
 				$grade = 2.50;
 				break;
 			case $totalMarks>=45:
 				$grade = 2.25;
 				break;
 			case $totalMarks>=40:
 				$grade = 2.00;
 				break;
 			default:
 				$grade = 0.00;
 				break;
 		}
 		return $grade;
 	}
 	public function remarks($rem)
 	{
 		$remarks = " ";
 		$rem = intval($rem);
 		if($rem==1)
 		{
 			$remarks = "Retake";
 		}
 		else
 		{
 			$remarks = " ";
 		}
 		return $remarks;
 	}


}

?>
