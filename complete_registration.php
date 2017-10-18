<?php

require_once('includes/connect.php');
require_once("includes/functions.php");

if(!isset($_SESSION))
{
	session_start();
}
$email = "what?";
if(isset($_SESSION['email']))
{
	$email = $_SESSION['email'];
	//echo $email;
}
if(isset($_POST['complete_registration']))
{
	
	
	$studentId = $_POST['studentId'];
	$batch = $_POST['batch'];
	$varsityId = $_POST['varsityId'];
	$deptId = $_POST['deptId'];

	//$password = md5($rawPassword);
	
	$response = $functions->studentRegisterComplete($email,$studentId,$batch,$varsityId,$deptId);
	
	if($response)
	{
		$_SESSION['message'] = "Registration Successfull!";
		$functions->redirect('login.php');
		
	}
	else
	{
		$info = "<div class=\"alert alert-danger fade in\">";
		$info .= "<a href = '#' class=\"close\" data-dismiss=\"alert\" aria-lebel=\"close\">&times;</a> Registration failed / User already exists.";
		$info .= "</div>";
		
		echo $info;


	}
	
}




?>

<html>
<head>
<link rel="stylesheet" href="resources/css/bootstrap.css">


</head>
<body>
  <div class="container">
	<div style="padding:20px;margin-top:50px" ></div>
	<div id="popUpWindow">
		<div class="modal-dialog">
			<div class="modal-content">
                <div class="modal-header text-center">


				<form name="regform" action="complete_registration.php" method="POST" onsubmit="return validateForm()">
					<fieldset>
					<legend><h3> <span class="glyphicon glyphicon-edit"></span>  Complete Registration </h3></legend>
					<table class="table table-striped">
				
						<tr>
							<td>Student ID *</td><td><input type="text" name="studentId" placeholder="Student ID" class="form-control" required></td>
						</tr>
						<tr>
							<td>Batch *</td><td><input type="text" name="batch" placeholder="Batch" class="form-control" required></td>
						</tr>
						<tr>
							<td>University *</td><td><select name="varsityId" class="from form-control">
							<?php
								global $con;
								$result = mysqli_query($con,"SELECT * FROM varsity");
								$data = "";
								while ($res = mysqli_fetch_assoc($result))
								{
									$data .= '<option value='.$res['id'].'>';
									$data .= $res['name'];
									$data .= '</option>';
								}
								echo $data;
							?>
							</select></td>
						</tr>
						<tr>
							<td>Department *</td><td><select name="deptId" class="from form-control">
							<?php
								global $con;
								$result = mysqli_query($con,"SELECT * FROM dept");
								$data = "";
								while ($res = mysqli_fetch_assoc($result))
								{
									$data .= '<option value='.$res['id'].'>';
									$data .= $res['name'];
									$data .= '</option>';
								}
								echo $data;
							?>
							</select></td>
						</tr>
						<tr>
							<td></td><td><input type="submit" name="complete_registration" value="Complete Registration" class="btn btn-primary"></td>
						</tr>
						
					</table>

					
					</fieldset>
				</form>
				<div class="modal-footer text-right">
				<a href="login.php">Already have account? Login!</a> <br>
				</div>
				
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</head>

<?php
	include('templates/footer.php');
?>