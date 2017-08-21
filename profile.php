<?php
	require_once('includes/functions.php');
	include('templates/header.php');

	$userId = $functions->auth();

	$userName="";
	$email="";
	$sex="";
	$phone="";
	$fullName="";
	$role="";

	if($userId)
	{
		$result = $functions->getUserInfo($userId);
		while ($res = mysqli_fetch_assoc($result))
		{
			$userName = $res['userName'];
			$email = $res['email'];
			$fullName = $res['fullName'];
			$sex = $res['sex'];
			$phoneId = $res['phoneNo'];
			$role = $res['roleId'];
		}

    // Update basic info 
    if(isset($_POST['submit_update_basic']))
    {
      $userName = $_POST['userName'];
      $email = $_POST['email'];
      $fullName = $_POST['name'];

      $result = $functions->updateUser($userId,$userName,$fullName,$email);
      if($result)
      {
        $_SESSION['message'] = "Successfully Updated. ";
      }
      else
      {
        $_SESSION['message'] = "Can't Update. ";

      }
    }
	}
	

  // Page start and show message on top 
 if(isset($_SESSION['message']))
 {
  $info = "<div class = 'alert alert-success'>";
  $info .=  $_SESSION['message'];
  $info .= "</div>";
  echo $info;
  //session_unset($_SESSION['message']);
 }
?>
<h3></h3>
<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0 col-md-offset-3 col-lg-offset-3 toppad" >


  <div class="panel panel-info">
    <div class="panel-heading">
      <h3 class="panel-title"><?php echo $fullName; ?></h3>
    </div>
    <div class="panel-body">
      <div class="row">
        <div class="col-md-3 col-lg-3 " align="center"> <img alt="User Pic" src="https://cdn.slidesharecdn.com/profile-photo-shahidcseku-48x48.jpg" class="img-circle img-responsive"> </div>
    
        <div class=" col-md-9 col-lg-9 "> 
        <div class="panel-heading alert-success">
         <h3 class="panel-title">Basic Information</h3>
        </div>
          <table class="table table-user-information">
            <tbody>
              <tr>
                <td>Full Name</td>
                <td id="fullName"><?php echo $fullName; ?></td>
              </tr>
              <tr>
                <td>User Name</td>
                <td id="userName"><?php echo $userName; ?></td>
              </tr>
             <tr>
                <td>Email</td>
                <td id="email"><a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a></td>
              </tr>

                <tr>
                <td>Gender</td>
                <td id="sex"><?php echo $sex; ?></td>
              </tr>

                <tr>
                <td>Phone No</td>
                <td id="phone"><?php echo "+880 1xxxxxxxxx"; ?></td>
              </tr>
              
             
            </tbody>
          </table>
    
<!--Extra Information Display here-->
<?php
   include('./includes/profile.blade.php');
?>

<!--Extra Information Display end-->

<!-- Modal for updating basic info -->
<button id="myBtn"  class="btn btn-primary" onclick="EditProfile();">Edit Profile</button>

 <!-- The Modal -->
<div id="modalUpdate" class="modal">
   <!-- Modal content -->
	<div class="modal-content">
     <div class="modal-header">
       <span class="close">&times;</span>
       <h2>Edit Profile</h2>    </div>

	    <div class="modal-body">
	      <form  method="POST" onsubmit="reload_page();">
	         <input id="id_update" type="text"  name="id" style="display: none";>
	          
	         <span class="badge badge-success">Name</span>
	         <input id="name_update"  type="text" class="form-control" name="name" placeholder="Name" required>

	          <span class="badge badge-success">User Name</span>
	         <input id="userName_update" type="text" class="form-control" name="userName" placeholder="User Name" required>

	          <span class="badge badge-success">Email</span>
	         <input id="email_update" type="text" class="form-control" name="email" placeholder="Email" required>

            <span class="badge badge-success">Phone</span>
           <input id="phone_update" type="text" class="form-control" name="phone" placeholder="Phone no" disabled="true">

	        <br>

	        <input type="submit" name="submit_update_basic"  value="Submit" class="btn btn-primary pull-right">
	       </form>
         <br>
	        <div>
	          <br>
	        	<!--Empty div for spacing-->
	        </div>
	      
 		</div>
	</div>
</div>
<!--Modal end-->

<!-- Modal for updating password-->
<button id="passwordBtn"  class="btn btn-primary" onclick="EditPassword();">Change Passowrd</button>

 <!-- The Modal -->
<div id="modalPassword" class="modal">
   <!-- Modal content -->
  <div class="modal-content">
     <div class="modal-header">
       <span class="close">&times;</span>
       <h2>Update Password</h2> 
      </div>

      <div class="modal-body">
        <form  method="POST" onsubmit="reload_page();">
           <input id="id_update" type="text"  name="id" style="display: none";>
            
           <span class="badge badge-success">Old Password</span>
           <input  type="password" class="form-control" name="oldPassword" placeholder="Old Password" required>

           <span class="badge badge-success">New Password</span>
           <input  type="password" class="form-control" name="newPassword" placeholder="New Password" required>

           <span class="badge badge-success">Confirm New Password</span>
           <input  type="password" class="form-control" name="confirmNewPassword" placeholder="Confirm New Password" required>

          <br>

          <input type="submit" name="submit_update_basic"  value="Submit" class="btn btn-primary pull-right">
         </form>
         <br>
          <div>
            <br>
            <!--Empty div for spacing-->
          </div>
        
    </div>
  </div>
</div>
<!--Modal end-->



<script type="text/javascript">
var span = document.getElementsByClassName("close")[0];
var span1 = document.getElementsByClassName("close")[1];
span.onclick = function() {
    modalUpdate.style.display = "none";

}
span1.onclick = function() {
    modalPassword.style.display = "none";

}
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if ( event.target == modalUpdate || event.target == modalPassword) {
        modalUpdate.style.display = "none";
        modalPassword.style.display = "none";
    }
     
}
// Load data to edit form
function EditProfile()
{
  modalUpdate.style.display = "block"; // show the modal

  // Data retriving form table to modal
  var name =document.getElementById ("fullName").innerText;
  var email =document.getElementById ("email").innerText;
  var userName =document.getElementById ("userName").innerText;


  // Update value into textbox
 
  document.getElementById('name_update').value = name;
  document.getElementById('email_update').value = email;
  document.getElementById('userName_update').value = userName;

}

function EditPassword()
{
  modalPassword.style.display = "block"; // show the modal

}


</script>

</div>
</div>
</div>