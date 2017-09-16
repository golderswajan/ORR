<?php
	/**
	*  Main page functions, Login, Registration etc
	*/
	$functions = new Functions;
	class Functions
	{
		
		function __construct()
		{
			if(!isset($_SESSION))
			{
				session_start();	
			}
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


		
		
		// Checks the user authentication and return email+userId
		function auth()
		{
			if(isset($_SESSION['userId']))
			{	
				$userId = $_SESSION['userId'];
			}
			else
			{
				$this->redirect('login.php');
			}
			return $userId;

		}

		function getRoles()
		{
			global $con;
			$sql = "SELECT * FROM role WHERE 1 ORDER BY roleName ASC";
			$result = mysqli_query($con,$sql);

			return $result;
		}
		//***********************************************
		// USER CODES HERE
		//***********************************************
		function userRegister($userType,$username,$fullname,$sex,$email,$password)
		{
			global $con;
			
			$queryUser = "INSERT INTO user(id,userName,fullName,email,password,sex,roleId,active) VALUES('','".$username."','".$fullname."','".$email."','".$password."','".$sex."',".$userType.",0)";
			$resultUser =mysqli_query($con,$queryUser);
			
			
			if($resultUser)
			{
				return true;
			}
			else
			{
				//echo mysqli_error($con);
				return false;
			}
			
		}

		function userLogin($email,$password)
		{
			global $con;
			$sql = "SELECT * FROM user WHERE email = '".$email."' AND password = '".$password."'";
			$resultUser =mysqli_query($con,$sql);



			//echo mysqli_error($con);

			$emailD ="";
			$passD ="";
			$userId = "";
			while ($res = mysqli_fetch_assoc($resultUser)) 
			{
				$emailD = $res['email'];
				$passD = $res['password'];
				$userId = $res['id'];
			}

			if($emailD==$email && $passD== $password)
			{
				// Universal Session never clear it until logged out.
				$_SESSION['userId'] = $userId;
				return true;
			}
			else
			{
				$_SESSION['message'] = "<script>alert('User doesn't exist or password is wrong')</script>";
				return false;
			}
		}

		public function getUserInfo($userId)
		{
			global $con;

			$sql = "SELECT * FROM user WHERE user.id = ".$userId;
			$result = mysqli_query($con,$sql);
			return $result;
		}
		//Return user type i.e. Student, teacher etc.
		public function getUserType($userId)
		{
			global $con;

			// Order: Teacher -> Student
			// Search Teacher
			$sqlTeacher = "SELECT * FROM teacher WHERE userId = ".$userId;
			$resultTeacher = mysqli_query($con,$sqlTeacher);
			
			while($res = mysqli_fetch_assoc($resultTeacher))
			{
				$arr = array('table' => 'teacher', 'id' => $res['id']);
				return $arr;
			}

			// Search Student
			$sqlStudent = "SELECT * FROM student WHERE userId = ".$userId;
			$resultStudent = mysqli_query($con,$sqlStudent);

			while($res = mysqli_fetch_assoc($resultStudent))
			{
				$arr = array('table' => 'student', 'id' => $res['id']);
				return $arr;
			}
			
		}

		public function updateUser($userId,$userName,$fullName,$email)
		{
			global $con;

			$sql = "UPDATE user SET userName ='".$userName."', fullname ='".$fullName."', email ='".$email."' WHERE id = ".$userId;
			$result = mysqli_query($con,$sql);
			return $result;
		}
		//***********************************************
		// USER SPECIFIC INFO CODES HERE
		//***********************************************
		public function getStudentSpecialInfo($userId)
		{
			global $con;
			$sql = "SELECT * FROM student WHERE userId = ".$userId;
			$result = mysqli_query($con,$sql);
			return $result;
		}
		public function getTeacherSpecialInfo($userId)
		{
			global $con;
			$sql = "SELECT * FROM teacher WHERE userId = ".$userId;
			$result = mysqli_query($con,$sql);
			return $result;
		}


	}
?>