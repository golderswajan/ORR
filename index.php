<?php
 include('templates/header.php');
 if(isset($_SESSION['message']))
 {
 	echo $_SESSION['message'];
 }

 if(isset($_SESSION['logged_in']))
 {
 	echo $_SESSION['logged_in'];
 }

?>

<?php
 include('templates/footer.php');
?>