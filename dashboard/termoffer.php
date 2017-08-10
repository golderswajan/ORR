<?php
include($_SERVER['DOCUMENT_ROOT'].'/se/templates/dashboardsidebar.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/dal/dal.university.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/dal/dal.term.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/dal/dal.year.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/dal/dal.department.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/dal/dal.termoffer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/dal/dal.degree.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/dal/dal.session.php');

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
            <tr id="termoffer_list">
                <th colspan="2"><h3 class="text-center">Term Offer Information</h3></th>
            </tr>
              <tr id="termoffer_list">
                <th >University</th>
                <th >Degree</th>
                <th >Session</th>
                <th >Term</th>
                <th >Status</th>
                <th class="text-right"> Edit</th>
                <th class="text-right"> Delete</th>
            </tr>
        </thead>
        <tbody>
           <?php
           require_once("bll/bll.termoffer.php");
           $content = $TermOffer->show();
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

 <button id="myBtn" class="btn btn-primary">Offer New Term</button>

<!-- Modal for insertion -->
 <!-- The Modal -->
 <div id="myModal" class="modal">
   <!-- Modal content -->
   <div class="modal-content">
     <div class="modal-header">
       <span class="close">&times;</span>
       <h2>Offer New Term</h2>    </div>

     <div class="modal-body">
      <form action="bll/bll.termoffer.php" method="POST" onsubmit="reload_page();">
      <input id="id" type="text"  name="id" style="display: none";>
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

        <span class="badge badge-success">Session</span>
         <select class="form-control" id="sessionId" name="sessionId">
      
         <?php
          $options = "";
          $obj = new DALSession;
          $result = $obj->get();
          while($res = mysqli_fetch_assoc($result))
          {
            $options .= '<option value="'.$res['id'].'">'.$res['sessionName'].'</option>';
          }
          echo $options;
         ?>
        </select>

        
        <br>
        
        <input type="submit" name="submit_insert" value="Submit" class="btn btn-primary pull-right">
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
       <h2>Edit Term Offered</h2>    </div>

<div class="modal-body">
      <form action="bll/bll.termoffer.php" method="POST" onsubmit="reload_page();">
        <input id="id_update" type="text"  name="id" style="display: none";>
        
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

        <span class="badge badge-success">Session</span>
         <select class="form-control" id="sessionId_update" name="sessionId">
      
         <?php
          $options = "";
          $obj = new DALSession;
          $result = $obj->get();
          while($res = mysqli_fetch_assoc($result))
          {
            $options .= '<option value="'.$res['id'].'">'.$res['sessionName'].'</option>';
          }
          echo $options;
         ?>
        </select>

        <span class="badge badge-success">Status</span>
         <select class="form-control" id="status_update" name="status">
           <option value="0">End</option>
           <option value="1">Running</option>
          </select>

        <br>
        
        <input type="submit" name="submit_update" value="Submit" class="btn btn-primary pull-right">
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
function EditTermOffer(id,yearId,termId,varsityId,deptId,degreeId,sessionId)
{

  modalUpdate.style.display = "block"; // show the modal

  // Handle no prerequisite
   if (prerequisiteId === undefined) {
          prerequisiteId = 0;
    } 

  // Data retriving form table to modal
  //var $row = $('#row_id'+id+'').closest("tr");

  // Update value into textbox
  $('#id_update').attr('value',id);
  $('#varsityId_update').val(varsityId);
  $('#deptId_update').val(deptId);
  $('#yearId_update').val(yearId);
  $('#termId_update').val(termId);
  $('#degreeId_update').val(degreeId);
  $('#sessionId_update').val(sessionId);

}

</script>

<!--Page Endings-->
    </div>
    </div>
    </div>
    </body>
</html>
