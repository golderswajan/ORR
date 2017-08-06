<?php
require_once('includes/connect.php');
require_once("includes/functions.php");

if(!isset($_SESSION))
{
	session_start();
}

if(isset($_POST['submit'])){
	

	$username = $_POST["Email"];
	$rawPassword = $_POST["Password"];
	$password = md5($rawPassword);
	

	$user_found = user_login($username,$password);
	
	 
	if($user_found)
	{
		$_SESSION['logged_in'] = $username;
		redirect("index.php");
	}
	else
	{
		echo "<script>alert('User doesn't exist or password is wrong')</script>";
		echo $_SESSION['message'];
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


				<form name="loginform" action="login.php" method="POST" onsubmit="return validateForm()">
					<fieldset>
					<legend><h3>  <span class="glyphicon glyphicon-log-in"></span> Login </h3></legend>
				  <div class="input-group">
					  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
					  <input id="email" type="text" class="form-control" name="Email" placeholder="Email">
					</div>
					<div class="input-group">
					  <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
					  <input id="password" type="password" class="form-control" name="Password" placeholder="Password">
					</div>
					<div class="text-left">  <input type="checkbox" checked="checked">   Keep me logged in </div>
					<input type="submit" name="submit" value="&nbsp;&nbsp; Login &nbsp; &nbsp;" class="btn btn-primary btn-block"  > <br><br>
					
					</fieldset>
				</form>
				<div class="modal-footer text-right">
				<a href="Registration.php">No account here? Signup now !</a> <br>
				</div>
				
				</div>
			</div>
		</div>
	</div>
</div>

</body>

<script>

function validateForm() {
    var x = document.forms["loginform"]["Email"].value;
	var y = document.forms["loginform"]["Password"].value;
    if (x == "") {
        alert("Please input email");
        return false;
    }
	else if (y == "") {
        alert("Please input password");
        return false;
    }
}
</script>
