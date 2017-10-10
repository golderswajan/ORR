<?php
include_once("bll/bll.courseregistrationapproval.php");
include('header.php');
if(isset($_SESSION['message']))
{
  $msg = "<div class='alert alert-success'>";
  $msg .= ($_SESSION['message']);
  $msg .= "</div>";
  echo $msg;
  unset($_SESSION['message']);
}
if(isset($_SESSION['exit']))
{
    // After successfull operation exit window within 2 sec.
    unset($_SESSION['exit']);
    echo '<script> window.setTimeout("window.close()", 2000); </script>';
}
?>

<!--Data display-->
<div id="table">
  <div class="col-lg-11">
    <table class="table">
        <thead>
            <tr id="student_registered">
                <th colspan="2"><h3 class="text-center">Registration Edit</h3></th>
            </tr>
              <tr id="student_registered">
                <th >Course No</th>
                <th >Course Title</th>
                <th> Credit</th>
                <th> Remove</th>
            </tr>
        </thead>
        <tbody>
       <?php
          if(isset($_GET['edit']))
          {
            $registeredTermId = $_GET['edit'];
            $bllCourseRegistrationApproval = new BLLCourseRegistrationApproval;
             
            echo $registeredCourses = $bllCourseRegistrationApproval->getRegisteredCourses($registeredTermId);
          }
       ?>
          
        </tbody>
    </table>

      <h3 class="pull-right">
          <?php
          echo '<a  class ="btn btn-primary" href="bll/bll.courseregistrationapproval.php?approve='.$_GET['edit'].'">Approve All</a>'
          ?>
      </h3>
    </div>
</div>
<!--Including the js files-->
<script type="text/javascript" src="../../resources/js/jquery.js"></script>
<script type="text/javascript" src="../../resources/js/jquery.min.js"></script>
<script type="text/javascript" src="../../resources/js/jquery-ui.js"></script>
<script type="text/javascript" src="../../resources/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="../../resources/js/modal.js"></script>


<!--Page Endings-->
    </div>
    </div>
    </div>
    </body>
</html>
