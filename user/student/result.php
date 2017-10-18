<?php
include_once("bll/bll.result.php");
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

<!-- Add new Modal-->
 <link rel="stylesheet" href="../../resources/css/modal.css">

 <button id="myBtn" class="btn btn-primary">Select a Term to see Result</button>

<!-- Modal for insertion -->
 <!-- The Modal -->
 <div id="myModal" class="modal">
   <!-- Modal content -->
   <div class="modal-content">
     <div class="modal-header">
       <span class="close">&times;</span>
       <h2>Select a Term</h2>    </div>

     <div class="modal-body">
      <form action="result.php" method="POST" onsubmit="reload_page();">
      
         <label for="terms">Select a Term</label>
        <select class="form form-control" name="registeredTermId" required> 
        <?php
          $option="";
          $result = $bllResult->getRegisteredTerms($studentId,$varsityDeptId);
        
          if($result)
          {
            echo $result;
          }
          else
          {
            $option .= "<option disabled='true' class='alert-danger'>Currently no registered term !</option>";

          }

          echo $option;
        ?>

         </select>
        <br>
        
        <input type="submit" name="submit_term_selected" value="Submit" class="btn btn-primary pull-right">
        <br>
       </form>
       <div >
         <br>
       </div>
      
   </div>

 </div>
 </div>

<h3 class="alert alert-info text-center">Result</h3>
<div id="table">
    <!-- Academic info -->

    <?php

    $varsity = "";
    $dept = "";
    $session = "";
    $year = "";
    $term = "";
    $name = "";

     if(isset($_POST['submit_term_selected']))
     {
        $result = $bllResult->getHeaderInfo($studentId,$varsityDeptId,$_POST['registeredTermId']);
        while ($res = mysqli_fetch_assoc($result))
        {
          $varsity = $res['varsityName'];
          $dept = $res['deptName'];
          $session = $res['sessionName'];
          $year = $res['year'];
          $term = $res['term'];
          $name = $res['fullName'];
        }

     }

    ?>
    <table class="center-block" style="width:auto;">
      <thead>
        <tr>
          <th class="h1" colspan="2">
          <?php
            if(isset($_POST['submit_term_selected']))
            {
              echo $varsity;
            }
          ?>
          </th>
        </tr>
        <tr>
          <th class="h4" colspan="2">
          <?php
            echo "STUDENT-WISE TABULATION SHEET";
          ?>
          </th>

        </tr>
      </thead>
      <tbody>
        <tr>
          <td> Year: <?php
            if(isset($_POST['submit_term_selected']))
            {
              echo $year;
            }
          ?>
          &nbsp;&nbsp;
          &nbsp;&nbsp;
          Term: <?php
            if(isset($_POST['submit_term_selected']))
            {
              echo $term;
            }
          ?></td>
          <td>Session: <?php
            if(isset($_POST['submit_term_selected']))
            {
              echo $session;
            }
          ?></td>
        </tr>
        <tr>
          <td>Student No: <?php
            if(isset($_POST['submit_term_selected']))
            {
              echo $studentId;
            }
          ?></td>
          <td>Student Name: <?php
            if(isset($_POST['submit_term_selected']))
            {
              echo $name;
            }
          ?></td>
        </tr>
        <tr>
          <td>Department: <?php
            if(isset($_POST['submit_term_selected']))
            {
              echo $dept;
            }
          ?></td>
          <td>Faculty: [Will be added in next version]</td>
        </tr>
      </tbody>
    </table>
    <br>
    <!-- Courses and calculations  -->
    <table class="table table-bordered">
      <thead>
        <tr id="result_list">
          <th >Course No.<br><br><br><br></th>
          <th >Course Title<br><br><br><br></th>
          <th >Registered <br>Credit <br>Hours<br><br></th>
          <th >Latter<br>Grade<br><br><br></th>
          <th >Grade<br>Point<br><br>(GP)</th>
          <th >Earned<br>Credit <br>Hours <br>(CH)</th>
          <th >Earned <br>Credit <br>Points <br>(GPxCH)</th>
          <th >Remarks<br><br><br><br></th>
      </tr>
      </thead>
      <tbody>
        <?php
        // Display data 
        if(isset($_POST['submit_term_selected']))
        {

          $data = $bllResult->show($_POST['registeredTermId']);
          echo $data;

        }
        
        ?>
      </tbody>
      <tfoot>
        <table>
          <tbody>
            <?php
           // Display data 
           if(isset($_POST['submit_term_selected']))
           {

              $data = $bllResult->showFooter($_POST['registeredTermId']);
              echo $data;

           }
          
           ?>
          </tbody>
        </table>
      </tfoot>
    </table>
    <br>
    <br>
    <br>
    <ul class="list-inline">
      <li class="list-item overline">
        Signature of First Tabulator <br>Date:
      </li>
      <li class="list-item overline">
        Signature of the Chairman, Examination Comittee<br>Date:
      </li>
      <li class="list-item pull-right overline">
        Signature of Second Tabulator<br>Date:
        
      </li>
      
    </ul>
</div>

<!--Including the js files-->
<script type="text/javascript" src="../../resources/js/jquery.js"></script>
<script type="text/javascript" src="../../resources/js/jquery.min.js"></script>
<script type="text/javascript" src="../../resources/js/edit_modal.js"></script>
<script type="text/javascript" src="../../resources/js/jquery-ui.js"></script>
<script type="text/javascript" src="../../resources/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="../../resources/js/modal.js"></script>

<style type="text/css">
  .overline {
    width: auto;
    border-top: 2px solid black;
}
</style>
<!--Page Endings-->
    </div>
    </div>
    </div>
    </body>
</html>
