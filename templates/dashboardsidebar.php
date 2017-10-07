<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!--http-equiv is for testing perpouse only-->
<!--meta http-equiv="refresh" content="10"-->
<?php
if(!isset($_SESSION))
  {
      session_start();
  }

// Authentication
  if(isset($_SESSION['globaladmin']))
    {
      $email = $_SESSION['globaladmin'];
    }
    else
    {
      header("Location:../login.php");
    }
// Authentication end
echo '<link rel="stylesheet" type="text/css" href="/se/resources/css/dashboardsidebar.css">';
echo '<link rel="stylesheet" type="text/css" href="/se/resources/css/bootstrap.css">';
echo '<link rel="stylesheet" type="text/css" href="/se/resources/css/bootstrap.min.css">';
echo '<link rel="stylesheet" type="text/css" href="/se/resources/css/jquery-ui.css">';
echo '<link rel="stylesheet" type="text/css" href="/se/resources/css/font-awesome.min.css">';
echo '<link rel="stylesheet" type="text/css" href="/se/resources/css/font-awesome.css">';
echo '<link rel="stylesheet" type="text/css" href="/se/resources/css/custom.css">';

?>
<script type="text/javascript" >
  
function expandNav() {
  
    document.getElementById("mySidenav").style.width = "200px";
    document.getElementById("smallSidenav").style.width = "0px";
    document.getElementById("main").style.marginLeft = "200px";
  }
function closeNav() {
    document.getElementById("mySidenav").style.width = "0px";
    document.getElementById("smallSidenav").style.width = "50px";
     document.getElementById("main").style.marginLeft = "0px";
}
</script>
</head>
<body>
<!-- Wrapper contains the whole content-->
<div id="page-content-wrapper">
<div class="container">
<!-- Siderab starts-->
<div id="mySidenav" class="sidenav" >
<ul class="nav nav-pills nav-stacked">

  <li> <a href="javascript:void(0)" class="expandbtn" onclick="closeNav()"><span class="glyphicon glyphicon-align-justify"></span></a></li>

  <?php
    function DashboardMenu()
    {
      $xml = simplexml_load_file($_SERVER['DOCUMENT_ROOT'].'/se/settings/menu.xml');
      $menu = "";
      foreach($xml->items as $item)
      {
        $menu .= '<li> <a href="'.$item->link.'"><span class="'.$item->icon.'"></span> '.$item->title.'</a></li>';
      }
      return $menu;
      
    }
    echo DashboardMenu();

  ?>

</ul>

</div>

<div id="smallSidenav" class="smallsidenav" >

<ul class="nav nav-pills nav-stacked">
  <li> <a href="javascript:void(0)" class="expandbtn" onclick="expandNav()"><span class="glyphicon glyphicon-align-justify"></span></a></li>

 <?php

    function DashboardMenuSmall()
    {
      $xml = simplexml_load_file($_SERVER['DOCUMENT_ROOT'].'/se/settings/menu.xml');
      $menu = "";
      foreach($xml->items as $item)
      {
        $menu .= '<li> <a href="'.$item->link.'" data-toggle="tooltip" data-placement="right" title="'.$item->title.'"><span class="'.$item->icon.'"></span></a></li>';
      }
      return $menu;
      
    }
    echo DashboardMenuSmall();

  ?>
</ul>

</div>

<!--Sidebar ends-->

<div id="main">
