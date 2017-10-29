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
	public function show($sessionSelected,$degreeSelected,$yearSelected,$termSelected,$varsityDeptId)
	{
		$dalRemuneration = new DALRemuneration;
		$result = $dalRemuneration->getRemunerationReport($sessionSelected,$degreeSelected,$yearSelected,$termSelected,$varsityDeptId);

		$data = "";
		while ($res = mysqli_fetch_assoc($result))
		 {	
		 	$data.="<tr>";
		 	$data.="<td>";
		 	$data.= $res['prefix']." ".$res['courseNo'];
		 	$data.="</td>";
		 	$data.="<td>";
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
	}
}
?>
