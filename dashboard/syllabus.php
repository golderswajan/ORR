<?php
include($_SERVER['DOCUMENT_ROOT'].'/se/templates/dashboardsidebar.php');
require_once("bll/bll.syllabus.php");
require_once("bll/bll.courseoffer.php");
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
            <tr id="syllabus_list">
                <th colspan="2"><h3 class="text-center">Term Syllabus</h3></th>
            </tr>
              <tr id="syllabus_list">
                <th >Term</th>
                <th >Min Credit</th>
                <th >Max Credit</th>
                <th class="text-right"> Edit</th>
                <th class="text-right"> Delete</th>
            </tr>
        </thead>
        <tbody>
           <?php
           // Display data 
           $content = $bllSyllabus->show();
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

 <button id="myBtn" class="btn btn-primary">Add New Syllabus</button>

<!-- Modal for insertion -->
 <!-- The Modal -->
 <div id="myModal" class="modal">
   <!-- Modal content -->
   <div class="modal-content">
     <div class="modal-header">
       <span class="close">&times;</span>
       <h2>Add New Syllabus</h2>    </div>

     <div class="modal-body">
      <form action="bll/bll.syllabus.php" method="POST" onsubmit="reload_page();">
      
         <label for="terms">Select a Term</label>
        <select class="form form-control" name="offeredTermId" required> 
         <?php
          $bllCourseOffer = new BLLCourseOffer;
          $result = $bllCourseOffer->offeredTermInfo();
          echo $result;
         ?>

         </select>
          <span class="badge badge-success">Min Credit</span>
         <input id="min" type="number"  step="0.25" class="form-control" name="minCredit" placeholder="Minimum credit of the Syllabus" required>

          <span class="badge badge-success">Max Credit</span>
         <input id="max" type="number" step="0.25" class="form-control" name="maxCredit" placeholder="Maximum credit of the Syllabus" required>
        <br>
        
        <input type="submit" name="submit_insert" value="Submit" class="btn btn-primary pull-right">
        <br>
       </form>
       <div >
         <br>
       </div>
      
   </div>

 </div>
 </div>



 <!-- Modal for updating -->
 <!-- The Modal -->
 <div id="modalUpdate" class="modal">
   <!-- Modal content -->
   <div class="modal-content">
     <div class="modal-header">
       <span class="close">&times;</span>
       <h2>Edit Syllabus</h2>    </div>

     <div class="modal-body">
     <form action="bll/bll.syllabus.php" method="POST" onsubmit="reload_page();">
      
         <input id="id_update" name="id" style="display: none">

         <label for="terms">Select a Term</label>
        <select class="form form-control" id="offeredTermId_update" name="offeredTermId" required> 
         <?php
          $bllCourseOffer = new BLLCourseOffer;
          $result = $bllCourseOffer->offeredTermInfo();
          echo $result;
         ?>

         </select>
          <span class="badge badge-success">Min Credit</span>
         <input id="min_update" type="number"  step="0.25" class="form-control" name="minCredit" placeholder="Minimum credit of the Syllabus" required>

          <span class="badge badge-success">Max Credit</span>
         <input id="max_update" type="number" step="0.25" class="form-control" name="maxCredit" placeholder="Maximum credit of the Syllabus" required>

        <br>
        
        <input type="submit" name="submit_update" value="Submit" class="btn btn-primary pull-right">
        <br>
       </form>
       <div >
         <br>
       </div>

 </div>
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
function EditSyllabus(id,offeredTermId)
{
  modalUpdate.style.display = "block"; // show the modal

  // get data form displayed table
  var $row = $('#row_id'+id+'').closest("tr");

  // Get values into variable

  //var offeredTermId = $row.find("td:nth-child(1)"); 
  var minCredit = $row.find("td:nth-child(2)"); 
  var maxCredit = $row.find("td:nth-child(3)"); 

  // Update value into textbox
  $('#id_update').attr('value',id);
   $('#offeredTermId_update').val(offeredTermId);
  $('#max_update').attr('value',$(maxCredit).text());
  $('#min_update').attr('value',$(minCredit).text());
  
  


}

</script>

<!--Page Endings-->
    </div>
    </div>
    </div>
    </body>
</html>
