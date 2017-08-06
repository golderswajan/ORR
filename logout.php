<?php 
require_once('includes/connect.php');
require_once("includes/functions.php");
if(!isset($_SESSION))
{
	session_start();
}
session_destroy();

redirect("index.php");


?>