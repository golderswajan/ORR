<?php
include_once("bll/bll.marksentry.php");
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
<h3 class="alert alert-info text-center">Marks Entry</h3>
<ul class="list-inline">
<li class="list-item">
<!--Session Selection-->
<form class="form-group" name="session" id="session" method="GET" action="marksentry.php" onsubmit="reload_page();">
    <label for="session">Session</label>
    
    <div class="input-group">
    <select class="form form-control" name="sessionSelected" required onchange="this.form.submit()";>  
      <option value="-1">Select a Session</option>
     <?php
      $dalMarksEntry = new DALMarksEntry;
      $result = $dalMarksEntry->getSessions($varsityDeptId);
      
      $post = "";
      while($res = mysqli_fetch_assoc($result))
      {
         if(isset($_GET['sessionSelected']) && $_GET['sessionSelected']==$res['sessionId'])
          {
            $post.= "<option value=".$res['sessionId']." selected=\"selected\">".$res['sessionName']."</option>";
          }
          else
          {
             $post.= "<option value=".$res['sessionId'].">".$res['sessionName']."</option>";
          }
      }
      echo $post;
     ?>
     </select>
   </div>
</form>
</li>

<li class="list-item">
<!--Degree Selection-->
<form class="form-group" name="degree" id="degree" method="GET" action="marksentry.php" onsubmit="reload_page();">

    <!-- Hold previous data-->
    <input type="text" name="sessionSelected" style="display: none" value="<?php if(isset($_GET['sessionSelected'])) echo $_GET['sessionSelected']?>">
    <!-- Hold previous data-->

    <label for="degree">Degree</label>
    
    <div class="input-group">
    <select class="form form-control" name="degreeSelected" required onchange="this.form.submit()";>  
      <option value="-1">Select a Degree</option>
     <?php
     if(isset($_GET['sessionSelected']))
      {
        $dalMarksEntry = new DALMarksEntry;
        $result = $dalMarksEntry->getDegrees($varsityDeptId,$_GET['sessionSelected']);
        
        $post = "";
        while($res = mysqli_fetch_assoc($result))
        {
           if(isset($_GET['degreeSelected']) && $_GET['degreeSelected']==$res['degreeId'])
            {
              $post.= "<option value=".$res['degreeId']." selected=\"selected\">".$res['degreeName']."</option>";
            }
            else
            {
               $post.= "<option value=".$res['degreeId'].">".$res['degreeName']."</option>";
            }
        }
        echo $post;
      }
     ?>
     </select>
   </div>
</form>
</li>

<li class="list-item">
<!--Year Selection-->
<form class="form-group" name="year" id="year" method="GET" action="marksentry.php" onsubmit="reload_page();">

    <!-- Hold previous data-->
   <input type="text" name="sessionSelected" style="display: none" value="<?php if(isset($_GET['sessionSelected'])) echo $_GET['sessionSelected']?>">
    <input type="text" name="degreeSelected" style="display: none" value="<?php if(isset($_GET['degreeSelected'])) echo $_GET['degreeSelected']?>">
    <!-- Hold previous data-->

    <label for="year">Year</label>

    <div class="input-group">

    <select class="form form-control" name="yearSelected" required onchange="this.form.submit()";>  
      <option value="-1">Select a Year</option>
     <?php

     
      if(isset($_GET['sessionSelected']) && isset($_GET['degreeSelected']))
      {
        $post = "";
        $result = $dalMarksEntry->getYears($varsityDeptId,$_GET['sessionSelected'],$_GET['degreeSelected']);
        
        while($res = mysqli_fetch_assoc($result))
        {
          if(isset($_GET['yearSelected']) && $_GET['yearSelected']==$res['yearId'])
          {
            $post.= "<option value=".$res['yearId']." selected=\"selected\">".$res['yearName']."</option>";
          }
          else
          {
             $post.= "<option value=".$res['yearId'].">".$res['yearName']."</option>";
          }
            
        }
        echo $post;
      }
     ?>
     </select>
   </div>
</form>
</li>


<li class="list-item">
<!--Term Selection-->
<form class="form-group" name="term" id="term" method="GET" action="marksentry.php" onsubmit="reload_page();">
    <!-- Hold previous data-->
   <input type="text" name="sessionSelected" style="display: none" value="<?php if(isset($_GET['sessionSelected'])) echo $_GET['sessionSelected']?>">
    <input type="text" name="degreeSelected" style="display: none" value="<?php if(isset($_GET['degreeSelected'])) echo $_GET['degreeSelected']?>">
    <input type="text" name="yearSelected" style="display: none" value="<?php if(isset($_GET['yearSelected'])) echo $_GET['yearSelected']?>">
    <!-- Hold previous data-->

    <label for="term">Term</label>

    <div class="input-group">

    <select class="form form-control" name="termSelected" required onchange="this.form.submit()";>  
      <option value="-1">Select a Term</option>
     <?php

     
      if(isset($_GET['sessionSelected']))
      {
        $post = "";
        $result = $dalMarksEntry->getTerms($varsityDeptId,$_GET['sessionSelected'],$_GET['degreeSelected'],$_GET['yearSelected']);
        
        while($res = mysqli_fetch_assoc($result))
        {
          if(isset($_GET['termSelected']) && $_GET['termSelected']==$res['termId'])
          {
            $post.= "<option value=".$res['termId']." selected=\"selected\">".$res['termName']."</option>";
          }
          else
          {
             $post.= "<option value=".$res['termId'].">".$res['termName']."</option>";
          }
            
        }
        echo $post;
      }
     ?>
     </select>
   </div>

</form>
</li>



<li class="list-item">
<!--Course Selection-->
<form class="form-group" name="offeredCourseSelected" id="offeredCourseSelected" method="GET" action="marksentry.php" onsubmit="reload_page();">
    <!-- Hold previous data-->
    <input type="text" name="sessionSelected" style="display: none" value="<?php if(isset($_GET['sessionSelected'])) echo $_GET['sessionSelected']?>">
    <input type="text" name="degreeSelected" style="display: none" value="<?php if(isset($_GET['degreeSelected'])) echo $_GET['degreeSelected']?>">
    <input type="text" name="yearSelected" style="display: none" value="<?php if(isset($_GET['yearSelected'])) echo $_GET['yearSelected']?>">
    <input type="text" name="termSelected" style="display: none" value="<?php if(isset($_GET['termSelected'])) echo $_GET['termSelected']?>">
    <input type="text" name="varsityDeptId" style="display: none" value="<?php echo $varsityDeptId;?>">
    <!-- Hold previous data-->

    <label for="term">Course</label>

    <div class="input-group">

    <select class="form form-control" name="offeredCourseSelected" required onchange="this.form.submit()";>  
      <option value="-1">Select a Course</option>
     <?php 
      if(isset($_GET['sessionSelected']) && isset($_GET['degreeSelected']) && isset($_GET['yearSelected']) && isset($_GET['termSelected']))
      {
        $bllMarksEntry = new BLLMarksEntry;
        $sessionSelected =  $_GET['sessionSelected'];
        $degreeSelected =  $_GET['degreeSelected'];
        $yearSelected =  $_GET['yearSelected'];
        $termSelected =  $_GET['termSelected'];

        $dalMarksEntry = new DALMarksEntry;
        $result = $dalMarksEntry->getOfferedCourses($sessionSelected,$degreeSelected,$yearSelected,$termSelected,$varsityDeptId);
        
        $post = "";
        while($res = mysqli_fetch_assoc($result))
        {
           if(isset($_GET['offeredCourseSelected']) && $_GET['offeredCourseSelected']==$res['offeredCourseId'])
            {
              $post.= "<option value=".$res['offeredCourseId']." selected=\"selected\">".$res['courseTitle']."</option>";
            }
            else
            {
               $post.= "<option value=".$res['offeredCourseId'].">".$res['courseTitle']."</option>";
            }
        }
        echo $post;
      }
    ?>
     </select>
   </div>

</form>
</li>
<li class="list-item">
<!--Mark section Selection-->
<form class="form-group" name="offeredCourseSelected" id="offeredCourseSelected" method="GET" action="bll/bll.marksentry.php" onsubmit="reload_page();">
    <!-- Hold previous data-->
    <input type="text" name="sessionSelected" style="display: none" value="<?php if(isset($_GET['sessionSelected'])) echo $_GET['sessionSelected']?>">
    <input type="text" name="degreeSelected" style="display: none" value="<?php if(isset($_GET['degreeSelected'])) echo $_GET['degreeSelected']?>">
    <input type="text" name="yearSelected" style="display: none" value="<?php if(isset($_GET['yearSelected'])) echo $_GET['yearSelected']?>">
    <input type="text" name="termSelected" style="display: none" value="<?php if(isset($_GET['termSelected'])) echo $_GET['termSelected']?>">
    <input type="text" name="offeredCourseSelected" style="display: none" value="<?php if(isset($_GET['offeredCourseSelected'])) echo $_GET['offeredCourseSelected']?>">
    <input type="text" name="varsityDeptId" style="display: none" value="<?php echo $varsityDeptId;?>">
    <!-- Hold previous data-->

    <label for="term">Mark Sections</label>

    <div class="input-group">

     <?php 
      if(isset($_GET['sessionSelected']) && isset($_GET['degreeSelected']) && isset($_GET['yearSelected']) && isset($_GET['termSelected']) && isset($_GET['offeredCourseSelected']))
      {

        $dalMarksEntry = new DALMarksEntry;
        $result = $dalMarksEntry->getMarkSections();
        
        $post = "";
        while($res = mysqli_fetch_assoc($result))
        {
          $post.= '<label class="checkbox-inline">'; 
          $post.=  '<input type="checkbox"  name="check_list[]"  value="'.$res['id'].'"> '.$res['name'].'</label>';

        }
        echo $post;

      $submit = '&nbsp;&nbsp;&nbsp;&nbsp;';
      $submit .='<input type="submit" name="load_mark_table" value="Create Mark Table" class="btn btn-primary">';
      echo $submit;
      }
    ?>
      
   </div>
</form>
</li>
</ul>

<!--End of fetch phase===========================================================-->

<!--Data display-->
<form action="bll/bll.marksentry.php" method="POST">
<div id="table">
  <div class="col-lg-12">
    <table class="table">
        <thead>
            <tr id="student_registered">
                <th colspan="2"><h3 class="text-center">Marks Entry Table</h3></th>
            </tr>
              <tr id="student_registered">
                <th>SL</th>
                <th>Student No</th>
                <?php
                  if(isset($_GET['sessionSelected']) && isset($_GET['degreeSelected']) && isset($_GET['yearSelected']) && isset($_GET['termSelected']) && isset($_GET['offeredCourseSelected']))
                  {
                    $offeredCourseSelected =  $_GET['offeredCourseSelected'];
        
                    $bllMarksEntry = new BLLMarksEntry;
                    $result = $bllMarksEntry->getHeaders($offeredCourseSelected);
                   echo $result;
                  }
                ?>
            </tr>
        </thead>
        <tbody>
           <?php
              if(isset($_GET['sessionSelected']) && isset($_GET['degreeSelected']) && isset($_GET['yearSelected']) && isset($_GET['termSelected']) && isset($_GET['offeredCourseSelected']))
              {
                $sessionSelected =  $_GET['sessionSelected'];
                $degreeSelected =  $_GET['degreeSelected'];
                $yearSelected =  $_GET['yearSelected'];
                $termSelected =  $_GET['termSelected'];
                $offeredCourseSelected =  $_GET['offeredCourseSelected'];
    
                $bllMarksEntry = new BLLMarksEntry;
                $result = $bllMarksEntry->getRegisteredCourses($sessionSelected,$degreeSelected,$yearSelected,$termSelected,$offeredCourseSelected,$varsityDeptId);
               echo $result;
              }
           ?>
          
        </tbody>
        <tfoot>

        </tfoot>
    </table>
    </div>
</div>
<input type="submit" name="marksentry" class="btn btn-primary pull-right" value="Submit Data">
</form>
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
