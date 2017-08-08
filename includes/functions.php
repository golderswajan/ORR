<?php
	/**
	*  Main page functions, Login, Registration etc
	*/
	$function = new Index;
	class Index
	{
		
		function __construct()
		{
			# code...
		}

		//***********************************************
		//Redirect to given location
		//***********************************************
		function redirect($location)
		{
			header("Location:".$location);
			exit;
			
		}

		//***********************************************
		//TIME AND DATE CODES HERE
		//***********************************************

		function getTime()
		{
			$time = time();
			$date_time = date('Y-m-d H:i:s',$time);
			
			return $date_time;
		}
		function getDt()
		{
			$time = time();
			$date_time = date('Y-m-d',$time);
			return $date_time;
		}
		function getTm()
		{
			$time = time();
			$date_time = date('H:i:s',$time);
			return $date_time;
		}


		//***********************************************
		// USER CODES HERE
		//***********************************************


		function user_register($username,$fullname,$sex,$email,$password)
		{
			global $con;
			
			$query_user = "INSERT INTO usermeta VALUES('','".$username."','".$fullname."','".$email."','".$sex."','".$password."')";
			$result_user =mysqli_query($con,$query_user);
			confirm_query($result_user);
			
			if($result_user)
			{
				return true;
			}
			return false;
		}

		function user_login($username,$password)
		{
			global $con;
			$query_user = "SELECT usermeta.id,usermeta.userName,usermeta.fullName,usermeta.email,usermeta.sex,usermeta.password,user.id as userId FROM usermeta,user WHERE usermeta.id = user.metaId AND usermeta.email = '".$username."' AND password = '".$password."'";
			$result_user =mysqli_query($con,$query_user);
			$confirmation =mysqli_fetch_assoc($result_user);
			//echo $confirmation['email'];
			
			if($confirmation['email']==$username && $confirmation['password']== $password)
			{
				$_SESSION['userId'] = $confirmation['userId'];
				return true;
			}
			else
			{
				$_SESSION['message'] = "<script>alert('User doesn't exist or password is wrong')</script>";
				return false;
			}
		}

	

	}
?>