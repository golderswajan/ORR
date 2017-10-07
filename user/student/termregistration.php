<?php
include_once("bll/bll.termregistration.php");
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
<h3 class="alert alert-info text-center">Registered Terms</h3>
<div id="table">
    <table class="table">
        <thead>
              <tr id="termregistration_list">
                <th >Term</th>
                <th >Total Registered Credit</th>
                <th >Total Earned Credit</th>
            </tr>
        </thead>
        <tbody>
           <?php
           // Display data 
           $content = $bllTermRegistration->show($studentId);
           echo $content;
           ?>
        </tbody>

    </table>
</div>

<!-- Add new Modal-->
 <link rel="stylesheet" href="../../resources/css/modal.css">

 <button id="myBtn" class="btn btn-primary">Register New Term</button>

<!-- Modal for insertion -->
 <!-- The Modal -->
 <div id="myModal" class="modal">
   <!-- Modal content -->
   <div class="modal-content">
     <div class="modal-header">
       <span class="close">&times;</span>
       <h2>Register New Term</h2>    </div>

     <div class="modal-body">
      <form action="bll/bll.termregistration.php" method="POST" onsubmit="reload_page();">
      
         <label for="terms">Select a Term</label>
        <select class="form form-control" name="offeredTermId" required> 
        <?php
          $option="";
          $result = $bllTermRegistration->getOfferedTerms($studentId,$varsityDeptId);
        
          if($result)
          {
            $degree = $utility->getDegreeName($result['degreeId']);
            $session = $utility->getSessionName($result['sessionId']);
            $year = $utility->getYearName($result['yearId']);
            $term = $utility->getTermName($result['termId']);
            $offeredTermId = $result['offeredTermId'] ;
            $option .= "<option value=$offeredTermId>$degree->$session->$year-$term Term</option>";
          }
          else
          {
            $option .= "<option disabled='true' class='alert-danger'>Currently no term offered for you to register !</option>";

          }

          echo $option;
        ?>

         </select>
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
