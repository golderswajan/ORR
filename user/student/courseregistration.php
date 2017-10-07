<?php
include_once("bll/bll.courseregistration.php");
include('header.php');
if(isset($_SESSION['message']))
{
  $msg = "<div class='alert alert-success'>";
  $msg .= ($_SESSION['message']);
  $msg .= "</div>";
  echo $msg;
  unset($_SESSION['message']);
}

?>

<h3 class="alert alert-info text-center">Register New Courses</h3>
  
<!--Course registration form-->
<form  method="POST" action="bll/bll.courseregistration.php">
<?php

if(isset($_SESSION['student']))
{
        $bllCourseRegistration = new BLLCourseRegistration;
        $result = $bllCourseRegistration->getOfferedCourses($studentId);

        $post = "<select class='form form-control' name='offeredCourseId' required multiple size='10'>  ";
        $post.= $result;
        $post.= " </select>";
        echo $post;  

        $currentRegisteredTermId = '<input  type="text"  name="registeredTermId" value="'.$bllCourseRegistration->getCurrentRegisteredTerm($studentId).'" style="display: none";>';
        echo $currentRegisteredTermId;

}
?>
    <br>
    <input type="submit" class="btn btn-primary pull-right" name="submit_course_registration" value="Register" >
    <br>
   </form>


<!-- All the terms-> courses registered -->
<h3 class="alert alert-info text-center">Registered Courses</h3>
<?php
echo $bllCourseRegistration->show($studentId);
?>
<!-- All the terms-> courses registered end-->

<!--Including the js files-->
<script type="text/javascript" src="../../resources/js/jquery.js"></script>
<script type="text/javascript" src="../../resources/js/jquery.min.js"></script>
<script type="text/javascript" src="../../resources/js/edit_modal.js"></script>
<script type="text/javascript" src="../../resources/js/jquery-ui.js"></script>
<script type="text/javascript" src="../../resources/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="../../resources/js/modal.js"></script>


<!--Page Endings-->
    </div>
    </div>
    </div>
    </body>
</html>
