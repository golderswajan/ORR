<?php
include_once("bll/bll.assigntabulator.php");
include('header.php');
$bllAssignTabulator = new BLLAssignTabulator;

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
  <h3 class="well alert-success text-center">Assign Tabulator</h3>
    <!--Input part -->
  <div class="row center-block">
    <div class="col-sm-8">
      
      <form class="form-group" id="assigntabulator" method="POST" action="bll/bll.assigntabulator.php" onsubmit="reload_page();">

        <label for="tabulatorId">Select User</label>

        <select class="form form-control" name="tabulatorId" required;>  
         <?php
          $result = $bllAssignTabulator->getTabulators();
          echo $result;
         ?>

         </select>

        <label >Select Term(s) &nbsp;&nbsp;&nbsp; [List of running terms]</label>
        <select class='form form-control' name='offeredTermsId[]'  multiple size='10'> 
         <?php
         
            $result = $bllAssignTabulator->getOfferedTerms($varsityDeptId);
            echo $result; 
         ?>
       </select>
        <br>
         <input type="submit" class="btn btn-primary pull-right" name="assigntabulator" value="Submit" >
      </form>
   
    </div>
  </div>
</div>

<!--Display Data-->

<div id="table">
    <table class="table">
        <thead>
            <tr id="tabulator_list">
                <th colspan="2"><h3 class="text-center">Tabulator Information</h3></th>
            </tr>
              <tr id="tabulator_list">
                <th >Tabulator's Name</th>
                <th >Assigned Terms</th>
                <th class="text-right"> Edit / End</th>
            </tr>
        </thead>
        <tbody>
           <?php
           $data = $bllAssignTabulator->show($varsityDeptId);
           echo $data;
           ?>
        </tbody>
        <tfoot>
          <td colspan="3"><p  class="alert-danger">** Tabulators are assigned for current term only.</p> </td>
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
