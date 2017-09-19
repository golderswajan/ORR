<?php
require_once('../utility.php');
include_once("bll/bll.courseregistration.php");
include('header.php');
if(isset($_SESSION['message']))
{
  $msg = "<div class='alert alert-success'>";
  $msg .= ($_SESSION['message']);
  $msg .= "</div>";
  echo $msg;
  session_unset($_SESSION['message']);
}
// Student All information

$studentId=150206;
$varsityId = "";
$deptId = "";
$varsityDeptId = "";

if(isset($_SESSION['logged_in']))
  {
    $email = $_SESSION['logged_in'];
    echo "<br>::Test::<br>";
    echo "Email: $email<br>";
    $studentId = $utility->getStudentId($email);
    $varsityId = $utility->getVarsityId($email);
    $deptId = $utility->getDeptId($email);
    $varsityDeptId = $utility->getVarsityDeptId($email);
    echo "StudentId: $studentId<br>";
    echo "varsityId: $varsityId<br>";
    echo "deptId: $deptId<br>";
    echo "varsityDeptId: $varsityDeptId<br>";
    $_SESSION['studentId'] = $studentId;
  }
  else
  {
    $utility->redirect($_SERVER['DOCUMENT_ROOT'].'/se/index.php');
  }
?>

<h3 class="alert alert-info text-center">Register New Courses</h3>
   
<?php

if(isset($_SESSION['logged_in']))
{
        $bllCourseRegistration = new BLLCourseRegistration;
        $result = $bllCourseRegistration->getOfferedCourses($studentId);

        $post = "<select class='form form-control' name='courses' required multiple size='10'>  ";
        $post.= $result;
        $post.= " </select>";
        echo $post;  

        $currentRegisteredTermId = '<input  type="text"  name="registeredTermId" value="'.$bllCourseRegistration->getCurrentRegisteredTerm($studentId).'" style="display: none";>';
        echo $currentRegisteredTermId;

}
?>
    <br>
    <input type="submit" class="btn btn-primary pull-right" name="submit_insert" value="Register" >
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
