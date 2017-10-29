<?php
include_once("bll/bll.remuneration.php");
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
<h3 class="alert alert-info text-center">Course Wise Rmuneration</h3>
<ul class="list-inline">
<li class="list-item">
<!--Session Selection-->
<form class="form-group" name="session" id="session" method="GET" action="remuneration.php" onsubmit="reload_page();">
    <label for="session">Session</label>
    
    <div class="input-group">
    <select class="form form-control" name="sessionSelected" required onchange="this.form.submit()";>  
      <option value="-1">Select a Session</option>
     <?php
      $dalRemuneration = new DALRemuneration;
      $result = $dalRemuneration->getSessions($varsityDeptId);
      
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
<form class="form-group" name="degree" id="degree" method="GET" action="remuneration.php" onsubmit="reload_page();">

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
        $dalRemuneration = new DALRemuneration;
        $result = $dalRemuneration->getDegrees($varsityDeptId,$_GET['sessionSelected']);
        
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
<form class="form-group" name="year" id="year" method="GET" action="remuneration.php" onsubmit="reload_page();">

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
        $result = $dalRemuneration->getYears($varsityDeptId,$_GET['sessionSelected'],$_GET['degreeSelected']);
        
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
<form class="form-group" name="term" id="term" method="GET" action="remuneration.php" onsubmit="reload_page();">
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
        $result = $dalRemuneration->getTerms($varsityDeptId,$_GET['sessionSelected'],$_GET['degreeSelected'],$_GET['yearSelected']);
        
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
<!--Mark section Selection-->
<form class="form-group" name="remuneration" id="remuneration" method="GET"  onsubmit="reload_page();">
    <!-- Hold previous data-->
    <input type="text" name="sessionSelected" style="display: none" value="<?php if(isset($_GET['sessionSelected'])) echo $_GET['sessionSelected']?>">
    <input type="text" name="degreeSelected" style="display: none" value="<?php if(isset($_GET['degreeSelected'])) echo $_GET['degreeSelected']?>">
    <input type="text" name="yearSelected" style="display: none" value="<?php if(isset($_GET['yearSelected'])) echo $_GET['yearSelected']?>">
    <input type="text" name="termSelected" style="display: none" value="<?php if(isset($_GET['termSelected'])) echo $_GET['termSelected']?>">
    
    <input type="text" name="varsityDeptId" style="display: none" value="<?php echo $varsityDeptId;?>">
    <!-- Hold previous data-->
    <label for="term">&nbsp;</label>

    <div class="input-group">
    <input type="submit" name="remunerationReport" class="btn btn-primary" value="Get Report">
    </div>

</form>
</li>
</ul>

<!--End of fetch phase===========================================================-->

<!--Data Grid CRUD-->
<div id="table">
  <div class="col-lg-12">
    <table class="table  table-bordered">
        <thead>
            <th>Course No</th>
            <th>Name of the Examiners</th>
            <th>No. of Questions</th>
            <th>No. of scripts</th>
        </thead>
        <tbody>
<?php
  if(isset($_GET['remunerationReport']))
  {
    $sessionSelected =  $_GET['sessionSelected'];
    $degreeSelected =  $_GET['degreeSelected'];
    $yearSelected =  $_GET['yearSelected'];
    $termSelected =  $_GET['termSelected'];
    $varsityDeptId =  $_GET['varsityDeptId'];

    echo $response=$bllRemuneration->show($sessionSelected,$degreeSelected,$yearSelected,$termSelected,$varsityDeptId);
  }
?>
          
        </tbody>
        <tfoot>

        </tfoot>
    </table>

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
