<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/se/user/admin/dal/dal.remuneration.php');


// To activate the constructior crating an object. 
$bllRemuneration = new BLLRemuneration;

class BLLRemuneration
{

	function __construct()
	{

	}
	// Display the remuneration according to user and course
	public function showTheory($sessionSelected,$degreeSelected,$yearSelected,$termSelected,$varsityDeptId)
	{
		$dalRemuneration = new DALRemuneration;
		$result = $dalRemuneration->getTheoryCourses($sessionSelected,$degreeSelected,$yearSelected,$termSelected,$varsityDeptId);

		$course = array();
		$count = array();
		$i=0;

		while ($row = mysqli_fetch_assoc($result))
		{
			
			array_push($course,$row['prefix']." ".$row['courseNo']);
		}

		// Data printing 
		$result = $dalRemuneration->getTheoryCourses($sessionSelected,$degreeSelected,$yearSelected,$termSelected,$varsityDeptId);
		$data = "";
		while ($res = mysqli_fetch_assoc($result))
		 {	
		 	$data.="<tr>";

		 	$data.="<td>";
		 	$data.= $res['prefix']." ".$res['courseNo'];
		 	$data.="</td>";

		 	$data.="<td colspan='2'>";
		 	$data.= $res['fullName'];
		 	$data.="</td>";
		 	$data.="<td>";
		 	$data.= "01";
		 	$data.="</td>";
		 	$data.="<td>";
		 	$data.= $res['noScripts'];
		 	$data.="</td>";
		 	$data.="</tr>";

		 }
		 echo $data;
		 //var_dump($course);
	}
	// Display the remuneration according to user and course
	public function showSessional($sessionSelected,$degreeSelected,$yearSelected,$termSelected,$varsityDeptId)
	{
		$dalRemuneration = new DALRemuneration;
		$result = $dalRemuneration->getSessionalCourses($sessionSelected,$degreeSelected,$yearSelected,$termSelected,$varsityDeptId);

		$course = array();
		$count = array();
		$i=0;

		while ($row = mysqli_fetch_assoc($result))
		{
			
			array_push($course,$row['prefix']." ".$row['courseNo']);
		}

		// Data printing 
		$result = $dalRemuneration->getSessionalCourses($sessionSelected,$degreeSelected,$yearSelected,$termSelected,$varsityDeptId);
		$data = "";
		while ($res = mysqli_fetch_assoc($result))
		 {	
		 	$data.="<tr>";

		 	$data.="<td>";
		 	$data.= $res['prefix']." ".$res['courseNo'];
		 	$data.="</td>";

		 	$data.="<td colspan='2'>";
		 	$data.= $res['fullName'];
		 	$data.="</td>";
		 	$data.="<td>";
		 	$data.= $res['noScripts'];
		 	$data.="</td>";
		 	$data.="</tr>";

		 }
		 echo $data;
		 //var_dump($course);
	}
	// Display the remuneration according to user and course
	public function showClassTests($sessionSelected,$degreeSelected,$yearSelected,$termSelected,$varsityDeptId)
	{
		$dalRemuneration = new DALRemuneration;
		$result = $dalRemuneration->getClassTests($sessionSelected,$degreeSelected,$yearSelected,$termSelected,$varsityDeptId);

		$course = array();
		$count = array();
		$i=0;

		while ($row = mysqli_fetch_assoc($result))
		{
			
			array_push($course,$row['prefix']." ".$row['courseNo']);
		}

		// Data printing 
		$result = $dalRemuneration->getClassTests($sessionSelected,$degreeSelected,$yearSelected,$termSelected,$varsityDeptId);
		$data = "";
		while ($res = mysqli_fetch_assoc($result))
		 {	
		 	$data.="<tr>";

		 	$data.="<td>";
		 	$data.= $res['prefix']." ".$res['courseNo'];
		 	$data.="</td>";

		 	$data.="<td colspan='2'>";
		 	$data.= $res['fullName'];
		 	$data.="</td>";
		 	$data.="<td>";
		 	$data.= "03";
		 	$data.="</td>";
		 	$data.="<td>";
		 	$data.= $res['noScripts'];
		 	$data.="</td>";
		 	$data.="</tr>";

		 }
		 echo $data;
		 //var_dump($course);
	}
	// Display the remuneration according to user and course
	public function showModarationCommittee($sessionSelected,$degreeSelected,$yearSelected,$termSelected,$varsityDeptId)
	{
		$dalRemuneration = new DALRemuneration;
		
		// Data printing 
		$result = $dalRemuneration->getModarationCommittee($sessionSelected,$degreeSelected,$yearSelected,$termSelected,$varsityDeptId);
		$data = "";
		$sl = 'a';
		while ($res = mysqli_fetch_assoc($result))
		 {	
		 	$data.="<tr>";

		 	$data.="<td>";
		 	$data.= "(".$sl++.")";
		 	$data.="</td>";

		 	$data.="<td colspan='2'>";
		 	$data.= $res['name'];
		 	$data.="</td>";

		 	$data.="<td>";
		 	$data.= $res['designation'];
		 	$data.="</td>";
		 	$data.="</tr>";

		 }
		 echo $data;
		 //var_dump($course);
	}
	// Display the remuneration according to user and course
	public function showModarationCommitteeChairman($sessionSelected,$degreeSelected,$yearSelected,$termSelected,$varsityDeptId)
	{
		$dalRemuneration = new DALRemuneration;
		
		// Data printing 
		$result = $dalRemuneration->getModarationCommittee($sessionSelected,$degreeSelected,$yearSelected,$termSelected,$varsityDeptId);
		$data = "";

		while ($res = mysqli_fetch_assoc($result))
		 {	
		 	$data.="<tr>";

		 	$data.="<td colspan='2'>";
		 	$data.= $res['name'];
		 	$data.="</td>";

		 	$data.="<td>";
		 	$data.= $res['designation'];
		 	$data.="</td>";
		 	$data.="</tr>";
		 	break;

		 }
		 echo $data;
		 //var_dump($course);
	}
	// Display the remuneration according to user and course
	public function showAnswerPaperScrutiny($sessionSelected,$degreeSelected,$yearSelected,$termSelected,$varsityDeptId)
	{
		$dalRemuneration = new DALRemuneration;
		
		// Data printing 
		$result = $dalRemuneration->getAnswerPaperScrutiny($sessionSelected,$degreeSelected,$yearSelected,$termSelected,$varsityDeptId);
		$data = "";
		$sl = 'a';
		while ($res = mysqli_fetch_assoc($result))
		 {	
		 	$data.="<tr>";

		 	$data.="<td>";
		 	$data.= $res['fullName'];
		 	$data.="</td>";

		 	$data.="<td>";
		 	$data.= $res['noScripts'];
		 	$data.="</td>";
		 	$data.="</tr>";

		 }
		 echo $data;
		 //var_dump($course);
	}
	// Display the remuneration according to user and course
	public function showTabulationStudents($sessionSelected,$degreeSelected,$yearSelected,$termSelected,$varsityDeptId)
	{
		$dalRemuneration = new DALRemuneration;
		
		// Data printing 
		$result = $dalRemuneration->getTabulationStudents($sessionSelected,$degreeSelected,$yearSelected,$termSelected,$varsityDeptId);
		$data = "";
		$sl = 'a';
		while ($res = mysqli_fetch_assoc($result))
		 {	
		 	$data.="<tr>";

		 	$data.="<td>";
		 	$data.= $res['fullName'];
		 	$data.="</td>";

		 	$data.="<td>";
		 	$data.= $res['noStudents'];
		 	$data.="</td>";
		 	$data.="</tr>";

		 }
		 echo $data;
		 //var_dump($course);
	}

	// Display the remuneration according to user and course
	public function showTabulationCourses($sessionSelected,$degreeSelected,$yearSelected,$termSelected,$varsityDeptId)
	{
		$dalRemuneration = new DALRemuneration;
		
		// Data printing 
		$result = $dalRemuneration->getTabulationCourses($sessionSelected,$degreeSelected,$yearSelected,$termSelected,$varsityDeptId);
		$data = "";
		$sl = 'a';
		while ($res = mysqli_fetch_assoc($result))
		 {	
		 	$data.="<tr>";

		 	$data.="<td>";
		 	$data.= $res['fullName'];
		 	$data.="</td>";

		 	$data.="<td>";
		 	$data.= $res['noCourses'];
		 	$data.="</td>";
		 	$data.="</tr>";

		 }
		 echo $data;
		 //var_dump($course);
	}
}
?>
