<?php
include($_SERVER['DOCUMENT_ROOT'].'/se/templates/dashboardsidebar.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/dal/dal.university.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/dal/dal.term.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/dal/dal.year.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/dal/dal.department.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/dal/dal.course.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/dal/dal.degree.php');

if(isset($_SESSION['message']))
{
  $msg = "<div class='alert alert-success'>";
  $msg .= ($_SESSION['message']);
  $msg .= "</div>";
  echo $msg;
  session_unset($_SESSION['message']);
}
?>

<div id="table">
    <table class="table">
        <thead>
            <tr id="course_list">
                <th colspan="2"><h3 class="text-center">Course Information</h3></th>
            </tr>
              <tr id="course_list">
                <th >Course</th>
                <th >No</th>
                <th >Title</th>
                <th >Credit</th>
                <th >University</th>
                <th >Department</th>
                <!--th >Year</th>
                <th >Term</th-->
                <th class="text-right"> Edit</th>
                <th class="text-right"> Delete</th>
            </tr>
        </thead>
        <tbody>
           <?php
           require_once("bll/bll.course.php");
           $content = $bllCourse->show();
           echo $content;
           ?>
        </tbody>
        <tfoot>
            <!--tr>
                <td></td>
                <td>Total</td>
                <td>33</td>
            </tr-->
        </tfoot>
    </table>
</div>

<!-- Add new Modal-->
 <link rel="stylesheet" href="/se/resources/css/modal.css">

 <button id="myBtn" class="btn btn-primary">Crate New Course</button>

<!-- Modal for insertion -->
 <!-- The Modal -->
 <div id="myModal" class="modal">
   <!-- Modal content -->
   <div class="modal-content">
     <div class="modal-header">
       <span class="close">&times;</span>
       <h2>Add New Course</h2>    </div>

     <div class="modal-body">
      <form action="bll/bll.course.php" method="POST" onsubmit="reload_page();">
      
         <span class="badge badge-success">Prefix</span>
         <input id="prefix" type="text" class="form-control" name="prefix" placeholder="Prefix" required>

         <span class="badge badge-success">Course No</span>
         <input id="course_no" type="text" class="form-control" name="course_no" placeholder="Course No" required>

         <span class="badge badge-success">Title</span>
         <input id="course_title" type="text" class="form-control" name="course_title" placeholder="Title" required>

         <span class="badge badge-success">Credit</span>
         <input id="credit" type="text" class="form-control" name="credit" placeholder="Credit" required>

         <span class="badge badge-success">University</span>
         <select class="form-control" id="varsityId" name="varsityId">
         <?php
          $options = "";
          $obj = new DALUniversity;
          $result = $obj->get();
          while($res = mysqli_fetch_assoc($result))
          {
            $options .= '<option value="'.$res['id'].'">'.$res['name'].'</option>';
          }
          echo $options;
         ?>
        </select>

        <span class="badge badge-success">Department</span>
         <select class="form-control" id="deptId" name="deptId">
         <?php
          $options = "";
          $obj = new DALDepartment;
          $result = $obj->get();
          while($res = mysqli_fetch_assoc($result))
          {
            $options .= '<option value="'.$res['id'].'">'.$res['name'].'</option>';
          }
          echo $options;
         ?>
        </select>

        <span class="badge badge-success">Year</span>
         <select class="form-control" id="yearId" name="yearId">
         <?php
          $options = "";
          $obj = new DALYear;
          $result = $obj->get();
          while($res = mysqli_fetch_assoc($result))
          {
            $options .= '<option value="'.$res['id'].'">'.$res['year'].'</option>';
          }
          echo $options;
         ?>
        </select>
        <span class="badge badge-success">Term</span>
         <select class="form-control" id="termId" name="termId">
         <?php
          $options = "";
          $obj = new DALTerm;
          $result = $obj->get();
          while($res = mysqli_fetch_assoc($result))
          {
            $options .= '<option value="'.$res['id'].'">'.$res['term'].'</option>';
          }
          echo $options;
         ?>
        </select>

        <span class="badge badge-success">Degree</span>
         <select class="form-control" id="degreeId" name="degreeId">
         <?php
          $options = "";
          $obj = new DALDegree;
          $result = $obj->get();
          while($res = mysqli_fetch_assoc($result))
          {
            $options .= '<option value="'.$res['id'].'">'.$res['name'].'</option>';
          }
          echo $options;
         ?>
        </select>

        <span class="badge badge-success">Prerequisite</span>
         <select class="form-control" id="prerequisite" name="prerequisite">
         <option value="null"> No Prerequisite </option>
         <?php
          $options = "";
          $obj = new DALCourse;
          $result = $obj->get();
          while($res = mysqli_fetch_assoc($result))
          {
            $options .= '<option value="'.$res['id'].'">'.$res['prefix'].' '.$res['courseNo'].'=>'.$res['courseTitle'].'</option>';
          }
          echo $options;
         ?>
        </select>

        
        <br>
        
        <input type="submit" name="submit_insert_course" value="Submit" class="btn btn-primary pull-right">
        <br>
       </form>
       <div >
         <br>
       </div>
      
   </div>   <!-- Modal body end-->

 </div>
 </div>

 <!-- Modal for updating -->
 <!-- The Modal -->
 <div id="modalUpdate" class="modal">
   <!-- Modal content -->
   <div class="modal-content">
     <div class="modal-header">
       <span class="close">&times;</span>
       <h2>Edit Course</h2>    </div>

<div class="modal-body">
      <form action="bll/bll.course.php" method="POST" onsubmit="reload_page();">
        <input id="id_update" type="text"  name="id" style="display: none";>
         <span class="badge badge-success">Prefix</span>
         <input id="prefix_update" type="text" class="form-control" name="prefix" placeholder="Prefix" required>

         <span class="badge badge-success">Course No</span>
         <input id="course_no_update" type="text" class="form-control" name="course_no" placeholder="Course No" required>

         <span class="badge badge-success">Title</span>
         <input id="course_title_update" type="text" class="form-control" name="course_title" placeholder="Title" required>

         <span class="badge badge-success">Credit</span>
         <input id="credit_update" type="text" class="form-control" name="credit" placeholder="Credit" required>

         <span class="badge badge-success">University</span>
         <select class="form-control" id="varsityId_update" name="varsityId">
         <?php
          $options = "";
          $obj = new DALUniversity;
          $result = $obj->get();
          while($res = mysqli_fetch_assoc($result))
          {
            $options .= '<option value="'.$res['id'].'">'.$res['name'].'</option>';
          }
          echo $options;
         ?>
        </select>

        <span class="badge badge-success">Department</span>
         <select class="form-control" id="deptId_update" name="deptId">
         <?php
          $options = "";
          $obj = new DALDepartment;
          $result = $obj->get();
          while($res = mysqli_fetch_assoc($result))
          {
            $options .= '<option value="'.$res['id'].'">'.$res['name'].'</option>';
          }
          echo $options;
         ?>
        </select>

        <span class="badge badge-success">Year</span>
         <select class="form-control" id="yearId_update" name="yearId">
         <?php
          $options = "";
          $obj = new DALYear;
          $result = $obj->get();
          while($res = mysqli_fetch_assoc($result))
          {
            $options .= '<option value="'.$res['id'].'">'.$res['year'].'</option>';
          }
          echo $options;
         ?>
        </select>
        <span class="badge badge-success">Term</span>
         <select class="form-control" id="termId_update" name="termId">
         <?php
          $options = "";
          $obj = new DALTerm;
          $result = $obj->get();
          while($res = mysqli_fetch_assoc($result))
          {
            $options .= '<option value="'.$res['id'].'">'.$res['term'].'</option>';
          }
          echo $options;
         ?>
        </select>

        <span class="badge badge-success">Degree</span>
         <select class="form-control" id="degreeId_update" name="degreeId">
         <?php
          $options = "";
          $obj = new DALDegree;
          $result = $obj->get();
          while($res = mysqli_fetch_assoc($result))
          {
            $options .= '<option value="'.$res['id'].'">'.$res['name'].'</option>';
          }
          echo $options;
         ?>
        </select>

        <span class="badge badge-success">Prerequisite</span>
         <select class="form-control" id="prerequisite_update" name="prerequisite">
         <option value="NULL"> No Prerequisite </option>
         <?php
          $options = "";
          $obj = new DALCourse;
          $result = $obj->get();
          while($res = mysqli_fetch_assoc($result))
          {
            $options .= '<option value="'.$res['id'].'">'.$res['prefix'].' '.$res['courseNo'].'=>'.$res['courseTitle'].'</option>';
          }
          echo $options;
         ?>
        </select>

        
        <br>
        
        <input type="submit" name="submit_update_course" value="Submit" class="btn btn-primary pull-right">
        <br>
       </form>
       <div >
         <br>
       </div>
      
   </div>   <!-- Modal body end-->
 </div>
 </div>
<!--Modal end-->

<!--Delete confirmation dialog-->
<div id="dialog" title="delete"></div>


<!--Including the js files-->
<script type="text/javascript" src="/se/resources/js/jquery.js"></script>
<script type="text/javascript" src="/se/resources/js/jquery.min.js"></script>
<script type="text/javascript" src="/se/resources/js/edit_modal.js"></script>
<script type="text/javascript" src="/se/resources/js/jquery-ui.js"></script>
<script type="text/javascript" src="/se/resources/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="/se/resources/js/confirm_delete.js"></script>


<script type="text/javascript">

// Function that call from bll to edit items
function EditCourse(id,yearId,termId,varsityId,deptId,degreeId,prerequisiteId)
{

  modalUpdate.style.display = "block"; // show the modal

  // Handle no prerequisite
   if (prerequisiteId === undefined) {
          prerequisiteId = "NULL";
    } 

  // Data retriving form table to modal
  var $row = $('#row_id'+id+'').closest("tr");

  // Get values into variable
  $prefix = $row.find("td:nth-child(1)");
  $course_no = $row.find("td:nth-child(2)");
  $course_title = $row.find("td:nth-child(3)");
  $credit = $row.find("td:nth-child(4)");


  // Update value into textbox
  $('#id_update').attr('value',id);
  $('#prefix_update').attr('value',$($prefix).text());
  $('#course_no_update').attr('value',$($course_no).text());
  $('#course_title_update').attr('value',$($course_title).text());
  $('#credit_update').attr('value',$($credit).text());
  $('#varsityId_update').val(varsityId);
  $('#deptId_update').val(deptId);
  $('#yearId_update').val(yearId);
  $('#termId_update').val(termId);
  $('#degreeId_update').val(degreeId);
  $('#prerequisite_update').val(prerequisiteId);

}

</script>

<!--Page Endings-->
    </div>
    </div>
    </div>
    </body>
</html>
