<!DOCTYPE html>
<?php //header('Content-Type: text/html; charset=utf-8');
include('../utility.php');
require('../../includes/connect.php');

?>
<html >
<head>
       <title>Welcome to University Management System</title>
	  <meta charset="UTF-8">
	  <meta name="about" content="SE project">

  <link rel="stylesheet" href="../../resources/css/bootstrap.css"/>
	<link rel="stylesheet" href="../../resources/css/bootstrap.min.css"/>
	<link rel="stylesheet" href="../../resources/css/simple-sidebar.css"/>
	<link rel="stylesheet" href="../../resources/css/BlockStyle.css"/>
	<link rel="stylesheet" href="../../resources/css/modal.css"/>
	<link rel="stylesheet" href="../../resources/css/font-awesome.css"/>
	<link rel="stylesheet" href="../../resources/css/bootstrap-theme.css"/>
  <link rel="stylesheet" href="../../resources/css/bootstrap-theme.min.css"/>
	<link rel="stylesheet" href="../../resources/css/dropdown.css"/>


  <script src="js/bootstrap.min.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="js/npm.js"></script>
	<script src="js/jquery.js"></script>
	<script src="js/header_collaps.js"></script>
  <script type="text/javascript" src="../../resources/jquery-ui/jquery-ui.js"></script>
  <script type="text/javascript" src="../../resources/jquery-ui/jquery-ui.min.js"></script>

<style type="text/css">
    #ubuntu{
        font-family: "Ubuntu Mono", Times, serif;
        font-size: 18px;
        /*font-style: italic;*/
        font-weight: bold;
      }
</style>
</head>
<body>


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
      <a class="navbar-brand" href="../../index.php">University Management</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="index.php"><span class="glyphicon glyphicon-home"></span> Home <span class="sr-only">(current)</span></a></li>
        </li>
		 
		 <li>
		 	
		<?php
		    function AdminMenu()
		    {
		      $xml = simplexml_load_file($_SERVER['DOCUMENT_ROOT'].'/se/settings/AdminMenu.xml');
		      $menu = "";
		      foreach($xml->submenu as $submenu)
		      {
            $menu.= "<li>";
            // Dropdown menu
            $title = $submenu->title;
            $menu.= '<div class="dropdown">';
            $menu.= '<button class="dropbtn">'.$title.'</button>';
            $menu.= '<div  class="dropdown-content">';
            foreach($submenu->items as $item)
            {
              $menu .= ' <a href="'.$item->link.'"><span class="'.$item->icon.'"></span> '.$item->title.'</a>';
            }
            $menu.= "</div>";
            $menu.= "</li>";
		        
		      }
		      return $menu;
		      
		    }
		    echo AdminMenu();

        

		 ?>
		 </li>
      </ul>

      <ul class="nav navbar-nav navbar-right">
      	<li>
      	<form class="navbar-form navbar-right" name='search_form' method="POST" action="index.php" onsubmit='return validateSearch()'>
        <div class="form-group">
          <input type="text" name='search_val' class="form-control" placeholder="Search">
        </div>
        <button type="submit" name = "search" class="btn btn-default"><span class="glyphicon glyphicon-search"></span></button>
      </form>
      	</li>

	 	<li><a href="../../logout.php">Log Out</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->

  </div><!-- /.container-fluid -->
</nav>

        <!-- Menubar End-->

		
<!--Navbar problem fixed :-) -->

<div style="padding:20px;margin-top:30px" />
<?php
// Authentication
        // Admin All information

        $varsityId = 0;
        $deptId =0;
        $varsityDeptId =0;

        if(isset($_SESSION['admin']))
          {
            $email = $_SESSION['admin'];
            // echo "<br>::Test::<br>";
            // echo "Email: $email<br>";
            // echo "Role: Admin<br>";

            $varsityId = $utility->getTeacherVarsityId($email);
            $deptId = $utility->getTeacherDeptId($email);
            $varsityDeptId = $utility->getTeacherVarsityDeptId($email);
    
            // echo "varsityId: $varsityId<br>";
            // echo "deptId: $deptId<br>";
            // echo "varsityDeptId: $varsityDeptId<br>";
          }
          else
          {
            $utility->redirect($_SERVER['DOCUMENT_ROOT'].'/se/index.php');
          }
?>

<script>
function validateSearch() {
    var val = document.forms["search_form"]["search_val"].value;
	
    if (val == "" || val == " ") {
        alert("Please input search value !");
        return false;
    }
	
}
</script>