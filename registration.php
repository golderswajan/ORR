<?php

require_once('includes/connect.php');
require_once("includes/functions.php");

if(!isset($_SESSION))
{
	session_start();
}

if(isset($_POST['submit'])){
	
	
	$username = $_POST["Username"];
	$fullname = $_POST['Full_Name'];
	$sex = $_POST['Sex'];
	$email = $_POST['Email'];
	$rawPassword = $_POST["Password"];
	$password = md5($rawPassword);
	
	
	if(user_register($username,$fullname,$sex,$email,$password))
	{
		$_SESSION['message'] = "Registration Successful !";
		redirect("login.php");
		
	}
	else{
		$info = "<div class=\"alert alert-danger fade in\">";
		$info .= "<a href = '#' class=\"close\" data-dismiss=\"alert\" aria-lebel=\"close\">&times;</a> Registration failed / User already exists.";
		$info .= "</div>";
		
		echo $info;

	}
	
}




?>

<html>
<head>
<link rel="stylesheet" href="public/css/bootstrap.css">


</head>
<body>
  <div class="container">
	<div style="padding:20px;margin-top:50px" ></div>
	<div id="popUpWindow">
		<div class="modal-dialog">
			<div class="modal-content">
                <div class="modal-header text-center">


				<form name="regform" action="registration.php" method="POST" onsubmit="return validateForm()">
					<fieldset>
					<legend><h3> <span class="glyphicon glyphicon-edit"></span>  Registration </h3></legend>
					<table class="table table-condensed">
					
						<tr>
							<td>Username *</td><td><input type="text" name="Username" placeholder="Username" class="form-control"></td>
						</tr>
						<tr>
							<td>Full Name *</td><td><input type="text" name="Full_Name" placeholder="Full Name" class="form-control"></td>
						</tr>
						<tr>
							<td>Sex *</td><td><select name="Sex" class="from form-control">
							<option value="Female">Female</option>
							<option value="Male">Male</option>
							</select></td>
						</tr>
						<tr>
							<td>Email *</td><td><input type="email" name="Email" placeholder="Email" class="form-control"></td>
						</tr>
						
						<tr>
							<td>Password *</td><td><input type="password" name="Password" placeholder="Password" class="form-control"></td>
						</tr>
						<tr>
							<td></td><td><input type="submit" name="submit" value="&nbsp;&nbsp; Register &nbsp; &nbsp;" class="btn btn-primary btn-block"  ></td>
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
	include('includes/footer.php');
?>
<script>

function validateForm() {
	var Username = document.forms["regform"]["Username"].value;
	var Full_Name = document.forms["regform"]["Full_Name"].value;
    var x = document.forms["regform"]["Email"].value;
	var y = document.forms["regform"]["Password"].value;
	
	if(Username == "")
	{
		alert("Please input Username");
        return false;
	}
	else if(Full_Name == "")
	{
		alert("Please input Full Name");
        return false;
	}
	else if (x == "") {
        alert("Please input email");
        return false;
    }
	else if (y == "") {
        alert("Please input password");
        return false;
    }
	
}
</script>