<?php
include_once("bll/bll.assignteacher.php");
include('header.php');
$bllAssignTeacher = new BLLAssignTeacher;

if(isset($_SESSION['message']))
{
  $msg = "<div class='alert alert-success'>";
  $msg .= ($_SESSION['message']);
  $msg .= "</div>";
  echo $msg;
  unset($_SESSION['message']);
}
?>
<div class="content">
  <h3 class="well alert-success text-center">Assign Course Teacher</h3>
    <!--Input part -->
  <div class="row center-block">
    <div class="col-sm-8">
      
      <form class="form-group" id="assignteacher" method="POST" action="bll/bll.assignteacher.php" onsubmit="reload_page();">

        <label for="teacher">Select Teacher</label>

        <select class="form form-control" name="teacherId" required;>  
         <?php
          $result = $bllAssignTeacher->getTeachers($varsityDeptId);
          echo $result;
         ?>

         </select>

        <label >Select Course(s) &nbsp;&nbsp;&nbsp; [List of running courses]</label>
        <select class='form form-control' name='offeredCourseId[]'  multiple size='10'> 
         <?php
         
            $result = $bllAssignTeacher->getCourses($varsityDeptId);
            echo $result; 
         ?>
       </select>
        <br>
         <input type="submit" class="btn btn-primary pull-right" name="assign_teacher" value="Submit" >
      </form>
   
    </div>
  </div>
</div>

<!--Display Data-->

<div id="table">
    <table class="table">
        <thead>
            <tr id="course_teacher_list">
                <th colspan="2"><h3 class="text-center">Course Teacher Information</h3></th>
            </tr>
              <tr id="course_teacher_list">
                <th >Teacher Name</th>
                <th >Assigned Course</th>
                <th class="text-right"> Edit / End</th>
            </tr>
        </thead>
        <tbody>
           <?php
           $data = $bllAssignTeacher->show($varsityDeptId);
           echo $data;
           ?>
        </tbody>
        <tfoot>
          <td colspan="3"><p  class="alert-danger">** Teachers are assigned for current term only.</p> </td>
        </tfoot>
    </table>
</div>

<!--Delete confirmation dialog-->
<div id="dialog" title="delete"></div>

<!--Including the js files-->
<script type="text/javascript" src="/se/resources/js/jquery.js"></script>
<script type="text/javascript" src="/se/resources/js/jquery.min.js"></script>
<script type="text/javascript" src="/se/resources/js/edit_modal.js"></script>
<script type="text/javascript" src="/se/resources/js/jquery-ui.js"></script>
<script type="text/javascript" src="/se/resources/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="/se/resources/js/confirm_delete.js"></script>


<!--Page Endings-->
    </div>
    </div>
    </div>
    </body>
</html>
