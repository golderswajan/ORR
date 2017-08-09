<?php 
	require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/connect.php');
	require_once($_SERVER['DOCUMENT_ROOT'].'/se/includes/functions.php');
	include($_SERVER['DOCUMENT_ROOT'].'/se/templates/dashboardsidebar.php');
?>

<!-- Page Content -->

<div id="page-content-wrapper">
<div class="container">
<?php
echo "<h3 class='text-center'>University Management Statistics</h3>";


$stat = "";
$stat .= "<div class='col-lg-12'>";

$stat .="<div class='row'>";
$stat .="<div class='col-md-3'>";
$stat .="<div class='panel  noti-box'>";
$stat .="<span class='icon-box bg-color-red set-icon'>";
$stat .="<span class='glyphicon glyphicon-list-alt'></span>";
$stat .="</span>";
$stat .="<div class='text-box'>";

$stat .="<p class='main-text'>Post</p>";
$stat .="<p class='text-muted'>Total <span class='badge alert-danger'>posts</span></p>";

$stat .= "<br>";
$stat .="<p class='text-muted'>Posted today <span class='badge alert-danger'>posts_today</span></p>";
$stat .="<p class='text-muted'>Posted in this week <span class='badge alert-danger'>posts_week</span></p>";
$stat .="<p class='text-muted'>Posted in this month <span class='badge alert-danger'>posts_month</span></p>";
$stat .="<p class='text-muted'>Posted in this year <span class='badge alert-danger'>posts_year</span></p>";

$stat .="</div>";
$stat .="</div>";
$stat .="</div>";

//$stat .="<div class='row'>";
$stat .="<div class='col-md-3'>";
$stat .="<div class='panel  noti-box'>";
$stat .="<span class='icon-box bg-color-red set-icon'>";
$stat .="<span class='glyphicon glyphicon-th-list'></span>";
$stat .="</span>";
$stat .="<div class='text-box' >";

$stat .="<p class='main-text'>Category</p>";
$stat .="<p class='text-muted'>Total <span class='badge alert-success'>  </span></p>";

$stat .= "<br>";
$stat .="<p class='text-muted'>New added in this month <span class='badge alert-success'>   </span></p>";
$stat .="<p class='text-muted'>New added in this year <span class='badge alert-success'>   </span></p>";

$stat .="</div>";
$stat .="</div>";
$stat .="</div>";	




//$stat .="<div class='row'>";
$stat .="<div class='col-md-3'>";
$stat .="<div class='panel  noti-box'>";
$stat .="<span class='icon-box bg-color-red set-icon'>";
$stat .="<span class='glyphicon glyphicon-user'></span>";
$stat .="</span>";
$stat .="<div class='text-box' >";

$stat .="<p class='main-text'>User</p>";
$stat .="<p class='text-muted'>Total <span class='badge alert-info'> users </span></p>";

$stat .= "<br>";
$stat .="<p class='text-muted'>Registered today <span class='badge alert-info'>users_today </span></p>";
$stat .="<p class='text-muted'>Registered in this week <span class='badge alert-info'> users_week </span></p>";
$stat .="<p class='text-muted'>Registered in this month <span class='badge alert-info'> users_month </span></p>";
$stat .="<p class='text-muted'>Registered in this year <span class='badge alert-info'> users_year </span></p>";

$stat .="</div>";
$stat .="</div>";
$stat .="</div>";


$stat .="</div>"; // First row ends

$stat .="<div class='row'>"; // 2nd row starts

$stat .="<div class='col-md-3'>";
$stat .="<div class='panel  noti-box'>";
$stat .="<span class='icon-box bg-color-red set-icon'>";
$stat .="<span class='glyphicon glyphicon-comment'></span>";
$stat .="</span>";
$stat .="<div class='text-box' >";

$stat .="<p class='main-text'>Comment</p>";
$stat .="<p class='text-muted'>Total <span class='badge alert-primary'>comments </span></p>";

$stat .= "<br>";
$stat .="<p class='text-muted'>Posted today <span class='badge alert-primary'> comments_today </span></p>";
$stat .="<p class='text-muted'>Posted in this week <span class='badge alert-primary'> comments_week </span></p>";
$stat .="<p class='text-muted'>Posted in this month <span class='badge alert-primary'>comments_month </span></p>";
$stat .="<p class='text-muted'>Posted in this year <span class='badge alert-primary'> comments_year </span></p>";

$stat .="</div>";
$stat .="</div>";
$stat .="</div>";


$stat .="<div class='col-md-3'>";
$stat .="<div class='panel  noti-box'>";
$stat .="<span class='icon-box bg-color-red set-icon'>";
$stat .="<span class='glyphicon glyphicon-thumbs-up'></span>";
$stat .="</span>";
$stat .="<div class='text-box' >";

$stat .="<p class='main-text'>Like</p>";
$stat .="<p class='text-muted'>Total <span class='badge alert-warning'> users </span></p>";

$stat .= "<br>";
$stat .="<p class='text-muted'>Hit today<span class='badge alert-warning'> users </span></p>";
$stat .="<p class='text-muted'>Hit in this week <span class='badge alert-warning'> users </span></p>";
$stat .="<p class='text-muted'>Hit in this month <span class='badge alert-warning'> users </span></p>";

$stat .="</div>";
$stat .="</div>";
$stat .="</div>";

$stat .="</div>";  // 2nd row ends 

echo $stat;

?>	
