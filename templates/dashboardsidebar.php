<html>
<head>
<meta name="viewport" width="device-width">

<?php
echo '<link rel="stylesheet" type="text/css" href="/se/resources/css/dashboardsidebar.css">';
echo '<link rel="stylesheet" type="text/css" href="/se/resources/css/bootstrap.css">';
echo '<link rel="stylesheet" type="text/css" href="/se/resources/css/bootstrap.min.css">';
echo '<link rel="stylesheet" type="text/css" href="/se/resources/css/jquery-ui.css">';

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
  <li> <a href="dashboard.php"><span class="glyphicon glyphicon-dashboard"></span>  Dashboard</a></li>
  <li> <a href="library.php"><span class="glyphicon glyphicon-globe"></span>  Library</a></li>
  <li> <a href="#"><span class="glyphicon glyphicon-glyphicon glyphicon glyphicon-sort-by-alphabet"></span>  Category</a></li>
  <li> <a href="#"><span class="glyphicon glyphicon glyphicon-shopping-cart"></span>  Shelf</a></li>
  <li> <a href="#"><span class="glyphicon glyphicon-book"></span>  Book</a></li>
  <li> <a href="#"><span class="glyphicon glyphicon-user"></span>  User</a></li>
  <li> <a href="#"><span class="glyphicon glyphicon-envelope"></span>  Transacton</a></li>
</ul>

</div>

<div id="smallSidenav" class="smallsidenav" >

<ul class="nav nav-pills nav-stacked">
  <li> <a href="javascript:void(0)" class="expandbtn" onclick="expandNav()"><span class="glyphicon glyphicon-align-justify"></span></a></li>

  <li> <a href="dashboard.php" data-toggle="tooltip" data-placement="right" title="Dashboard"><span class="glyphicon glyphicon-dashboard"></span></a></li>
  <li> <a href="library.php" data-toggle="tooltip" data-placement="right" title="Library"><span class="glyphicon glyphicon-globe"></span></a></li>
  <li> <a href="#" data-toggle="tooltip" data-placement="right" title="Category"><span class="glyphicon glyphicon-glyphicon glyphicon glyphicon-sort-by-alphabet" ></span></a></li>
  <li> <a href="#" data-toggle="tooltip" data-placement="right" title="Shelf"><span class="glyphicon glyphicon glyphicon-shopping-cart"></span></a></li>
  <li> <a href="#" data-toggle="tooltip" data-placement="right" title="Books"><span class="glyphicon glyphicon-book"></span></a></li>
  <li> <a href="#" data-toggle="tooltip" data-placement="right" title="User Profile"><span class="glyphicon glyphicon-user"></span></a></li>
  <li> <a href="#" data-toggle="tooltip" data-placement="right" title="Issuance"><span class="glyphicon glyphicon-envelope"></span></a></li>
</ul>

</div>

<!--Sidebar ends-->

<div id="main">
