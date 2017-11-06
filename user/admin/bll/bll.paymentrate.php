<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/se/user/admin/dal/dal.paymentrate.php');


// To activate the constructior crating an object. 
$bllPaymentRate = new BLLPaymentRate;

class BLLPaymentRate
{

	function __construct()
	{
		$dalPaymentRate = new DALPaymentRate;
		if(isset($_POST['insertPayment']))
		{
			$varsityDeptId = $_POST['varsityDeptId'];
			$degreeId = $_POST['degreeSelected'];
			$sessionId = $_POST['sessionSelected'];
			$yearId = $_POST['yearSelected'];
			$termId = $_POST['termSelected'];
			//echo $varsityDeptId.$degreeId.$sessionId.$yearId.$termId;

			$fieldName = $_POST['fieldName'];
			$amount = $_POST['amount'];
			$response = "";
			for($i = 0;$i<sizeof($fieldName);$i++)
			{
				$response = $dalPaymentRate->insert($sessionId,$degreeId,$yearId,$termId,$varsityDeptId,$fieldName[$i],$amount[$i]);
				//echo $fieldName[$i].$amount[$i];
			}
			if($response)
			{
				$_SESSION['message'] = "Successfully Inserted.";
			}
			else
			{
				$_SESSION['message'] = "Can't Insert.";
			}

			header('Location:'.$_SERVER['HTTP_REFERER']);
			exit();
		}
	}
	// Display the paymentrate according to user and course
	public function loadPaymentRate($sessionSelected,$degreeSelected,$yearSelected,$termSelected,$varsityDeptId)
	{
		$dalPaymentRate = new DALPaymentRate;
		$result = $dalPaymentRate->loadPaymentRate($sessionSelected,$degreeSelected,$yearSelected,$termSelected,$varsityDeptId);

		$data = "";
		if($row = mysqli_fetch_array( $result))
		{
			$sl = 1;
			while ($res = mysqli_fetch_assoc($result))
			{	
			 	$data.="<tr>";

			 	$data.="<td>";
			 	$data.= $sl++;
			 	$data.="</td>";

			 	$data.="<td>";
			 	$data.= $res['fieldName'];
			 	$data.="</td>";

			 	$data.="<td>";
			 	$data.= $res['amount'];
			 	$data.="</td>";
			 	$data.="</tr>";

			}
		}
		else
		{
			$data.="<tr>";
		 	$data.="<td colspan='3'>";
		 	$data.= "No data found! &nbsp;&nbsp;&nbsp; Create new payment rate? <a href='newpaymentrate.php'>Click Here</a>";
		 	$data.="</td>";
		 	$data.="</tr>";
		}
		echo $data;
	}
	
}
?>
