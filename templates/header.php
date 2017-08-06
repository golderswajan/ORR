<!DOCTYPE html>
<?php header('Content-Type: text/html; charset=utf-8');
	require('includes/connect.php');
?>
<html >
<head>
       <title>Welcome to Virtual Class</title>
	  <meta charset="UTF-8">
	  <meta name="about" content="SE project">

    <link rel="stylesheet" href="resources/css/bootstrap.css"/>
	<link rel="stylesheet" href="resources/css/bootstrap.min.css"/>
	<link rel="stylesheet" href="resources/css/simple-sidebar.css"/>
	<link rel="stylesheet" href="resources/css/BlockStyle.css"/>
	<link rel="stylesheet" href="resources/css/modal.css"/>
	<link rel="stylesheet" href="resources/css/font-awesome.css"/>
	<link rel="stylesheet" href="resources/css/bootstrap-theme.css"/>
	<link rel="stylesheet" href="resources/css/bootstrap-theme.min.css"/>


    <script src="js/bootstrap.min.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="js/npm.js"></script>
	<script src="js/jquery.js"></script>
	<script src="js/header_collaps.js"></script>

    <style>
      #bg {
          background-image:url("resources/img/pattern.png");
          background-repeat:repeat false;
		  background-attachment:fixed;
          font-family:Verdana;
      }
      #bg1{
      	background-color: #f6fbf4;
      }
  </style>
</head>
<body id="bg1">


<div class="navbar-header">

</div>
 <!-- Menubar Start-->
<nav class="navbar-inverse navbar-fixed-top" id="navbar">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">Virtual Class</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="index.php"><span class="glyphicon glyphicon-home"></span> Home <span class="sr-only">(current)</span></a></li>

        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-th-list"></span> Categories <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <?php
			global $con;

			$query_categories = "SELECT category.categoryName,category.id FROM category WHERE category.visible = 1 ORDER BY categoryName ASC";
			$result_categories=mysqli_query($con,$query_categories);
			$cat ="";
			while($category=mysqli_fetch_assoc($result_categories))
			{
				$cat .= "<li>";
				$cat .= "<a href=\"index.php?category=".$category["id"]."\">  <span class=\"glyphicon glyphicon-ok\"></span> ";
				$cat .= urlencode($category["categoryName"]);
				$cat .= "</a>";
				$cat .= "</li>";
			}
			echo $cat;
			?>
          </ul>
        </li>
		 <li><a href="forum.php"><span class="glyphicon glyphicon-paperclip"></span> Q/A</a></li>
		  <li><a href="featured.php"><span class="glyphicon glyphicon-pushpin"></span> Featured </a></li>
      </ul>
      <form class="navbar-form navbar-left" name='search_form' method="POST" action="index.php" onsubmit='return validateSearch()'>
        <div class="form-group">
          <input type="text" name='search_val' class="form-control" placeholder="Search">
        </div>
        <button type="submit" name = "search" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
      </form>
      <ul class="nav navbar-nav navbar-right">
	  
	  <!--  Login/Logout Button control start  -->
		
		<?php 
			if(!isset($_SESSION))
			{
				session_start();
			}
			//  <!-- Profile links start-->
			if(isset($_SESSION['logged_in'])){
				echo "<li><a href='dashboard/admin.php'><span class=\"glyphicon glyphicon-dashboard\"></span> Dashboard </a></li>";
				$profile_link = "profile.php?email=".$_SESSION['logged_in'];
				echo "<li><a href=".$profile_link."><span class=\"glyphicon glyphicon-user\"></span> Profile </a></li>";
			}
			else{
				echo "<li><a href=\"registration.php\"><span class=\"glyphicon glyphicon-user\"></span> Register </a></li>";
			}
			
			//<!-- Profile links end-->
			$btn_name="Login";
			$btn_link = "../se/login.php";
			
			if(isset($_SESSION["logged_in"]))
			{
				$btn_name = "Logut";
				$btn_link = "../se/logout.php";
			}
			echo "<li><a href=".$btn_link."><span class=\"glyphicon glyphicon-log-in\"></span> ".$btn_name."</a></li>";
		
		//  <!--  Login/Logout Button control end  -->	
		
		?>
	 
	  

        <!-- li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="#">Separated link</a></li>
          </ul>
        </li-->
		
      </ul>
    </div><!-- /.navbar-collapse -->

  </div><!-- /.container-fluid -->
</nav>

        <!-- Menubar End-->

		
<!--Navbar problem fixed :-) -->

<div style="padding:20px;margin-top:30px" />


<script>
function validateSearch() {
    var val = document.forms["search_form"]["search_val"].value;
	
    if (val == "" || val == " ") {
        alert("Please input search value !");
        return false;
    }
	
}
</script>