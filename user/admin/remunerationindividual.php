<?php
include_once("bll/bll.remunerationindividual.php");
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
<h3 class="alert alert-info text-center">Individual s</h3>
<ul class="list-inline">
<li class="list-item">
<!--Session Selection-->
<form class="form-group" name="session" id="session" method="GET" action="remunerationindividual.php" onsubmit="reload_page();">
    <label for="session">Session</label>
    
    <div class="input-group">
    <select class="form form-control" name="sessionSelected" required onchange="this.form.submit()";>  
      <option value="-1">Select a Session</option>
     <?php
      $dalRemunerationIndividual = new DALRemunerationIndividual;
      $result = $dalRemunerationIndividual->getSessions($varsityDeptId);
      
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
<form class="form-group" name="degree" id="degree" method="GET" action="remunerationindividual.php" onsubmit="reload_page();">

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
        $dalRemunerationIndividual = new DALRemunerationIndividual;
        $result = $dalRemunerationIndividual->getDegrees($varsityDeptId,$_GET['sessionSelected']);
        
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
<form class="form-group" name="year" id="year" method="GET" action="remunerationindividual.php" onsubmit="reload_page();">

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
        $result = $dalRemunerationIndividual->getYears($varsityDeptId,$_GET['sessionSelected'],$_GET['degreeSelected']);
        
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
<form class="form-group" name="term" id="term" method="GET" action="remunerationindividual.php" onsubmit="reload_page();">
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
        $result = $dalRemunerationIndividual->getTerms($varsityDeptId,$_GET['sessionSelected'],$_GET['degreeSelected'],$_GET['yearSelected']);
        
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
<!--Teacher Selection-->
<form class="form-group" name="teacher" id="teacher" method="GET" action="remunerationindividual.php" onsubmit="reload_page();">
    <!-- Hold previous data-->
   <input type="text" name="sessionSelected" style="display: none" value="<?php if(isset($_GET['sessionSelected'])) echo $_GET['sessionSelected']?>">
    <input type="text" name="degreeSelected" style="display: none" value="<?php if(isset($_GET['degreeSelected'])) echo $_GET['degreeSelected']?>">
    <input type="text" name="yearSelected" style="display: none" value="<?php if(isset($_GET['yearSelected'])) echo $_GET['yearSelected']?>">
    <input type="text" name="termSelected" style="display: none" value="<?php if(isset($_GET['termSelected'])) echo $_GET['termSelected']?>">
    <!-- Hold previous data-->

    <label for="term">Teacher</label>

    <div class="input-group">

    <select class="form form-control" name="teacherSelected" required onchange="this.form.submit()";>  
      <option value="-1">Select Teacher</option>
     <?php

     
      if(isset($_GET['termSelected']))
      {
        $post = "";
        $result = $dalRemunerationIndividual->getTeachers($varsityDeptId,$_GET['sessionSelected'],$_GET['degreeSelected'],$_GET['yearSelected'],$_GET['termSelected']);
        
        while($res = mysqli_fetch_assoc($result))
        {
          if(isset($_GET['teacherSelected']) && $_GET['teacherSelected']==$res['teacherId'])
          {
            $post.= "<option value=".$res['teacherId']." selected=\"selected\">".$res['fullName']."</option>";
          }
          else
          {
             $post.= "<option value=".$res['teacherId'].">".$res['fullName']."</option>";
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

<form class="form-group" name="remunerationindividual" id="remunerationindividual" method="GET"  onsubmit="reload_page();">
    <!-- Hold previous data-->
    <input type="text" name="sessionSelected" style="display: none" value="<?php if(isset($_GET['sessionSelected'])) echo $_GET['sessionSelected']?>">
    <input type="text" name="degreeSelected" style="display: none" value="<?php if(isset($_GET['degreeSelected'])) echo $_GET['degreeSelected']?>">
    <input type="text" name="yearSelected" style="display: none" value="<?php if(isset($_GET['yearSelected'])) echo $_GET['yearSelected']?>">
    <input type="text" name="termSelected" style="display: none" value="<?php if(isset($_GET['termSelected'])) echo $_GET['termSelected']?>">
      <input type="text" name="teacherSelected" style="display: none" value="<?php if(isset($_GET['teacherSelected'])) echo $_GET['teacherSelected']?>">
    
    <input type="text" name="varsityDeptId" style="display: none" value="<?php echo $varsityDeptId;?>">
    <!-- Hold previous data-->
    <label for="term">&nbsp;</label>

    <div class="input-group">
    <input type="submit" name="rr" class="btn btn-primary" value="Get Report">
    </div>

</form>
</li>
</ul>

<!--End of fetch phase===============================-->
<button class="btn btn-primary" onclick="CallPrint('print')">Print</button>

<div id="print">
<?php
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
#SET GLOBAL DATA FOR MULTIPEL USE 
#%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%%
if(isset($_GET['rr']))
{
  $varsityDeptId = $_GET['varsityDeptId'];
  $degreeId = $_GET['degreeSelected'];
  $sessionId = $_GET['sessionSelected'];
  $yearId = $_GET['yearSelected'];
  $termId = $_GET['termSelected'];
  $teacherId = $_GET['teacherSelected'];
}
?>
<!--Data Grid header-->
<?php
  if(isset($_GET['rr']))
  {
    $result = $dalRemunerationIndividual->getTeacherInfo($teacherId);
    while ($res = mysqli_fetch_assoc($result))
    {
      $tName = $res['fullName'];
      $tDesignation = $res['designation'];
      $tAddress = $res['address'];
      $tDept = $res['deptName'];
    }
  }
?>
<div id="table">
<center>
  <h2> খুলনা বিশ্ববিদ্যালয়, খুলনা </h3>
  <h4>পরীক্ষা নিয়ন্ত্রকের কার্যালয়</h4>
  <h3><u>পরীক্ষার পারিতোষিক বিল ফরম</u></h4>
  <h6>(প্রতি টার্মের জন্য পৃথক বিল ফরম ব্যবহার করতে হবে)</h6>
</center>
  <div class="col-lg-12">
    <table class="table table-bordered">
      <tr>
        <td>নাম :
          <?php
            if(isset($_GET['rr']))
            {
              echo $tName;
            }
          ?>
        </td>
        <td colspan="2">যে ডিসিপ্লিনের পরীক্ষা :
           <?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getDeptName($deptId);
            }
          ?>
        </td>
      </tr>
      <tr>
        <td>পদবী : <?php
            if(isset($_GET['rr']))
            {
              echo $tDesignation;
            }
          ?></td>
        <td>বর্ষ : <?php
            if(isset($_GET['rr']))
            {
              echo $_GET['yearSelected'];
            }
          ?></td><td>শিক্ষাবর্ষ : 
          <?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getSessionName($_GET['sessionSelected']);
            }
          ?>
          </td>
      </tr>
      <tr>
        <td>ডিসিপ্লিন/বিভাগ :
          <?php
            if(isset($_GET['rr']))
            {
              echo $tDept;
            }
          ?>
        </td>
        <td colspan="2">টার্ম : <?php
            if(isset($_GET['rr']))
            {
              echo $_GET['termSelected'];
            }
          ?>
           / স্পেশাল টার্ম পরীক্ষা</td>
      </tr>
       <tr>
        <td>ঠিকানা :
          <?php
            if(isset($_GET['rr']))
            {
              echo $tAddress;
            }
          ?>
        </td>
        <td colspan="2">পরীক্ষা অনুষ্ঠানের তারিখ .... থেকে .... পর্যন্ত </td>
      </tr>
       
    </table>
  </div>
</div>

<!--Data Grid Main-->
<div id="table">
 <center><h3><u> পরীক্ষা সংক্রান্ত কাজের বিবরণ </u></h3></center>
  <div class="col-lg-12">
    <table class="table table-bordered">
        <thead >
         <th>ক্রমিক <br>নং</th>
         <th>বিবরণ </th>
         <th>কোর্স নম্বর </th>
         <th>প্রশ্ন/খাতা/ছাত্র/কোর্স <br>পরীক্ষক/দিনের সংখা </th>
         <th>অর্ধ/পুর্নপত্র</th>
         <th>পারিতোষিকের হার</th>
         <th>মোট টাকা  </th>
        </thead>
        <tbody>
          <!-- Row 1 -->
          <tr>
            <td>১</td>
            <td>প্রশ্নপত্র প্রণয়ন</td>
            <td><input type="text" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getQuestionsComposition($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
            <td><input type="text" id="nQC" class="text-center" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getNoQuestionsComposition($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
            <td></td>
            <td><input type="text" id="rQC"  class="text-right" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getRateQuestionsComposition($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
            <td><input type="text" id="tQC"  class="text-right" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getTotalQuestionsComposition($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
          </tr>
           <!-- Row 2 -->
          <tr>
            <td>২</td>
            <td>প্রশ্নপত্র মডারেশন</td>
            <td><input type="text" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getQuestionsModaration($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
            <td><input type="text" id="nQM" class="text-center" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getNoQuestionsModaration($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
            <td></td>
            <td><input type="text" id="rQM" class="text-right" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getRateQuestionsModaration($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
            <td><input type="text" id="tQM" class="text-right" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getTotalQuestionsModaration($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
          </tr>
           <!-- Row 3 -->
          <tr>
            <td>৩</td>
            <td>উত্তরপত্র পরীক্ষন </td>
            <td><input type="text" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getAnswerScriptEvaluation($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
            <td><input type="text" id="nASE" class="text-center" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getNoAnswerScriptEvaluation($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
            <td></td>
            <td><input type="text" id="rASE" class="text-right" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getRateAnswerScriptEvaluation($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
            <td><input type="text" id="tASE" class="text-right" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getTotalAnswerScriptEvaluation($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
          </tr>
          <!-- Row 4 -->
          <tr>
            <td>৪</td>
            <td>ক্লাস টেস্ট/ টার্ম পেপার/ হোম ওয়ার্ক/ এসাইনমেন্ট </td>
             <td><input type="text" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getClassTest($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
            <td><input type="text" id="nCT" class="text-center" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getNoClassTest($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
            <td></td>
            <td><input type="text" id="rCT" class="text-right" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getRateClassTest($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
            <td><input type="text" id="tCT" class="text-right" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getTotalClassTest($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
          </tr>
          <!-- Row 5 -->
          <tr>
            <td>৫</td>
            <td>সেশনাল </td>
           <td><input type="text" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getSessional($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
            <td><input type="text" id="nS" class="text-center" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getNoSessional($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
            <td></td>
            <td><input type="text" id="rS" class="text-right" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getRateSessional($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
            <td><input type="text" id="tS" class="text-right" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getTotalSessional($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
          </tr>

          <!-- Row 6 -->
          <tr>
            <td>৬</td>
            <td>সেশনাল মৌখিক পরীক্ষা</td>
             <td><input type="text" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getSessionalViva($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
            <td><input type="text" id="nSV" class="text-center" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getNoSessionalViva($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
            <td></td>
            <td><input type="text" id="rSV" class="text-right" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getRateSessionalViva($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
            <td><input type="text" id="tSV" class="text-right" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getTotalSessionalViva($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
          </tr>
          <!-- Row 7 -->
          <tr>
            <td>৭</td>
            <td>প্রফেশনাল এটাসমেন্ট/ ইন্ডাস্টিয়াল (ট্রেনিং/ এটাসমেন্ট)</td>
             <td><input type="text" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getIndustrial($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
            <td><input type="text"  id="nI" class="text-center" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getNoIndustrial($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
            <td></td>
            <td><input type="text"  id="rI" class="text-right" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getRateIndustrial($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
            <td><input type="text" id="tI" class="text-right" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getTotalIndustrial($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
          </tr>
          <!-- Row 8 -->
          <tr>
            <td>৮</td>
            <td>উত্তরপত্র নিরীক্ষন </td>
             <td><input type="text" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getAnswerScriptExamination($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
            <td><input type="text"  id="nASEx" class="text-center" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getNoAnswerScriptExamination($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
            <td></td>
            <td><input type="text" id="rASEx" class="text-right" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getRateAnswerScriptExamination($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
            <td><input type="text" id="tASEx" class="text-right" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getTotalAnswerScriptExamination($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
          </tr>
          <!-- Row 9 -->
          <tr>
            <td>৯</td>
            <td>টেবুলেশন </td>
            <td><input type="text"   style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getTabulation($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
            <td><input type="text" id="nT" class="text-center" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getNoTabulation($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
            <td></td>
            <td><input type="text" id="rT" class="text-right" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getRateTabulation($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
            <td><input type="text" id="tT" class="text-right" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getTotalTabulation($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
          </tr>
          <!-- Row 10 -->
          <tr>
            <td>১০</td>
            <td>প্রশ্নপত্র প্রস্তুতকরণ (অংকন, স্টেনসিল কাটা ও ঘুরানো)</td>
            <td><input type="text" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getTabulation($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
            <td><input type="text" id="nD" class="text-center" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getNoTabulation($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
            <td></td>
            <td><input type="text" id="rD" class="text-right" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getRate($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
            <td><input type="text" id="tD" class="text-right" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getTotalTabulation($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
          </tr>
          <!-- Row 11-->
          <tr>
            <td>১১</td>
            <td>পরীক্ষা কমিটির সভাপতি </td>
            <td><input type="text" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getTabulation($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
            <td><input type="text" id="nH" class="text-center" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getNoTabulation($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
            <td></td>
            <td><input type="text" id="rH" class="text-right" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getRate($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
            <td><input type="text" id="tH" class="text-right" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getTotalTabulation($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
          </tr>
          <!-- Row 12 -->
          <tr>
            <td>১২</td>
            <td>চীফ ইনভিজিলেশন</td>
            <td><input type="text" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getTabulation($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
            <td><input type="text" id="nCI" class="text-center" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getNoTabulation($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
            <td></td>
            <td><input type="text" id="rCI" class="text-right" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getRate($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
            <td><input type="text" id="tCI" class="text-right" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getTotalTabulation($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
          </tr>
          <!-- Row 13 -->
          <tr>
            <td>১৩</td>
            <td>থিসিস </td>
            <td><input type="text" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getTabulation($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
            <td><input type="text" id="nTh" class="text-center" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getNoTabulation($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
            <td></td>
            <td><input type="text" id="rTh" class="text-right" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getRate($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
            <td><input type="text" id="tTh" class="text-right" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getTotalTabulation($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
          </tr>
          <!-- Row 14 -->
          <tr>
            <td>১৪</td>
            <td>কম্পিউটারে গ্রেড ও জিপিএ তালিকা প্রস্তুত ও ভেরিফিকেশন/ বিল নিরীক্ষণ </td>
            <td><input type="text" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getTabulation($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
            <td><input type="text" id="nCO" class="text-center" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getNoTabulation($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
            <td></td>
            <td><input type="text" id="rCO" class="text-right" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getRate($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
            <td><input type="text" id="tCO" class="text-right" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getTotalTabulation($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
          </tr>
          <!-- Row 15 -->
          <tr>
            <td>১৫</td>
            <td>অন্যান্য</td>
            <td><input type="text" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getTabulation($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
            <td><input type="text" id="nO" class="text-center" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getNoTabulation($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
            <td></td>
            <td><input type="text"  id="rO" class="text-right" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getRate($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
            <td><input type="text"  id="tO" class="text-right" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getTotalTabulation($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
          </tr>
           <!-- Footer 1 -->
          <tr>
            <td colspan="6" class="text-right">সর্বমোট টাকার পরিমাণ :</td> 
          <td><input type="text" id="subTotal" class="text-right" style="border:none" value="<?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getSubTotal($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }
            ?>"></td>
          </tr>
           <!-- Footer 2 -->
          <tr>
            <td colspan="7">সর্বমোট টাকার পরিমাণ (কথায়) : 
            <b id="totalInWord">
            <?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getSubTotalInWord($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId)." Only.";
            }?>
            <b>
          </td> 
          </tr>
          
          
        </tbody>
        <tfoot>

        </tfoot>
    </table>

    </div>
</div>
<!-- Data end -->
<!--Data Grid Footer-->


<br>
<br>
 <div class="row col-lg-12">
      <div class="col-sm-3 overline">
        ডিসিপ্লিন প্রধান <br>
        (স্বাক্ষর ও সীল)

      </div>
      <div class="col-sm-3 text-center overline">
        সভাপতি, পরীক্ষা কমিটি<br>(স্বাক্ষর ও সীল)
       </div>
      <div class="col-sm-6 pull-right">
        <p style="border: 2px solid; padding: 5px;">
        এই বিলের প্র্যাপ্য অর্থ অগ্রনী ব্যাংক, খুলনা বিশ্ববিদ্যালয় শাখায় আমার নামে রক্ষিত ........................... নং হিসাবে/চেকের মাধ্যমে পরিশোধের অনুরোধ করছি এবং এই মর্মে অঙ্গীকার করছি যে, এই বিলে আমি কোন অতিরিক্ত অর্থ দাবী করিনি। যদি ভবিষ্যতে এই বিলে কোন আপত্তি উত্থাপিত হয় তাহলে গৃহীত অর্থ ফেরত দিতে বাধ্য থাকব। 

        <br>
        <br>
        <span style="border: 2px solid; padding:3px;">
          বিঃদ্রঃ- প্রত্যেক বিলে রাজস্ব টিকেট লাগাতে হবে।
        </span>
        <span class="pull-right">প্রাপকের স্বাক্ষর ও তারিখ</span>
        </p>
      </div>
</div>
<div id="table">
  <center><h3><u> পরীক্ষা নিয়ন্ত্রকের কার্যালয়ে ব্যবহারের জন্য </u></h3></center>
  <div class="col-lg-12">
    <br>
    পরীক্ষার পারিতোষিক হার এবং ডিসিপ্লিন থেকে প্রাপ্ত স্টেটমেন্ট অনুযায়ী বিলসমূহ নিরীক্ষান্তে বিলের অর্থ পরিশোধের জন্য সুপারিশ করা হলো। 
    <br>
    <br>
    <ul class="list-inline">
      <li class="list-item overline">
       বিল নিরীক্ষক/সেকশন অফিসার/সহকারী পরীক্ষা নিয়ন্ত্রক 
      </li>
      <li class="list-item text-center overline">
        উপ-পরীক্ষা নিয়ন্ত্রক
      </li>
      <li class="list-item pull-right overline">
       পরীক্ষা নিয়ন্ত্রক 
        
      </li>
      
    </ul>
  </div>
</div>

<div id="table">
  <hr>
  <center><h3><u> অর্থ ও হিসাব বিভাগে ব্যবহারের জন্য</u></h3></center>
  <div class="col-lg-12">
    <br>
    পরীক্ষান্তে বর্নিত পারিতোষিক বিল বাবদ <b id="calcTotalDigit"> <?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getSubTotal($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId)." Tk.";
            }?> 
          </b>
            কথায়ঃ (<b id="calcTotalWord"><?php

            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getSubTotalInWord($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId);
            }?>) </b> )মাত্র পরিশোধের জন্য ছাড়া হল। 
  
    <br>
    <br>
    <ul class="list-inline">
      <li class="list-item overline">
       সেকশন অফিসার/সহকারী পরিচালক
      </li>
      <li class="list-item text-center overline">
        উপ-পরিচালক
      </li>
      <li class="list-item pull-right overline">
       পরিচালক
        
      </li>
    </ul>
  </div>
  <div class="col-lg-12" style="border: 2px dotted; padding: 5px;">
    <p>
        এই বিল পরিশোধে কোন আপত্তি নেই নিরীক্ষান্তে <b id="finalTotalDigit"><?php
            if(isset($_GET['rr']))
            {
              echo $bllRemunerationIndividual->getSubTotal($varsityDeptId,$degreeId,$sessionId,$yearId,$termId,$teacherId)." ";
            }?></b>
             টাকার বিলটি পরিশোধের সুপারিশ করা হলো। 
    </p>
    <ul class="list-inline">
      <li class="list-item overline">
      সহকারী পরিচালক(অডিট)
      </li>
      <li class="list-item pull-right overline">
       উপ-পরিচালক/প্রধান(অডিট সেল)
        
      </li>
    </ul>
  </div>
</div>
<br>
<br>
<br>
<br>
  <div class="col-lg-8">
    <p style="border: 2px solid; padding: 5px;" class="bnk">
      ব্যাংক আডভাইস/চেক নং- 0200004758299 তারিখঃ
              <?php
              echo date("D,d-m-Y");
              ?>
    </p>
  </div>
<!-- Data end -->
</div>
<!-- Print end -->
<!-- Javascript calculations -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>


<script>
// Question composition
$("#nQC , #rQC").bind("input change", function() {
  var rate = $('#rQC').val();
  var num = $('#nQC').val();
  $("#tQC").val(rate*num);
});
// Question modaratoin
$("#nQM , #rQM").bind("input change", function() {
  var rate = $('#rQM').val();
  var num = $('#nQM').val();
  $("#tQM").val(rate*num);
});
// Anser script evaluation
$("#nASE , #rASE").bind("input change", function() {
  var rate = $('#rASE').val();
  var num = $('#nASE').val();
  $("#tASE").val(rate*num);
});

// Class test
$("#nCT , #rCT").bind("input change", function() {
  var rate = $('#rCT').val();
  var num = $('#nCT').val();
  $("#tCT").val(rate*num);
});

// Sessional
$("#nS , #rS").bind("input change", function() {
  var rate = $('#rS').val();
  var num = $('#nS').val();
  $("#tS").val(rate*num);
});
// Sessional viva
$("#nSV , #rSV").bind("input change", function() {
  var rate = $('#rSV').val();
  var num = $('#nSV').val();
  $("#tSV").val(rate*num);
});
// Industrial
$("#nI , #rI").bind("input change", function() {
  var rate = $('#rI').val();
  var num = $('#nI').val();
  $("#tI").val(rate*num);
});
// Anser script examination
$("#nASEx , #rASEx").bind("input change", function() {
  var rate = $('#rASEx').val();
  var num = $('#nASEx').val();
  $("#tASEx").val(rate*num);
});
// Tabulation
$("#nT , #rT").bind("input change", function() {
  var rate = $('#rT').val();
  var num = $('#nT').val();
  $("#tT").val(rate*num);
});

// Drawing
$("#nD , #rD").bind("input change", function() {
  var rate = $('#rD').val();
  var num = $('#nD').val();
  $("#tD").val(rate*num);
});

// Chairman/Head of exm. com.
$("#nH , #rH").bind("input change", function() {
  var rate = $('#rH').val();
  var num = $('#nH').val();
  $("#tH").val(rate*num);
});

// Chief invisialtor
$("#nCI , #rCI").bind("input change", function() {
  var rate = $('#rCI').val();
  var num = $('#nCI').val();
  $("#tCI").val(rate*num);
});

// Thesis
$("#nTh , #rTh").bind("input change", function() {
  var rate = $('#rTh').val();
  var num = $('#nTh').val();
  $("#tTh").val(rate*num);
});

// Computer Operator
$("#nCO , #rCO").bind("input change", function() {
  var rate = $('#rCO').val();
  var num = $('#nCO').val();
  $("#tCO").val(rate*num);
});

// Others
$("#nO , #rO").bind("input change", function() {
  var rate = $('#rO').val();
  var num = $('#nO').val();
  $("#tO").val(rate*num);
});

$(window).click(function(){
  var t = parseInt($("#tQC").val());
  t += parseInt($("#tQM").val());
  t += parseInt($("#tASE").val());
  t += parseInt($("#tCT").val());
  t += parseInt($("#tS").val());
  t += parseInt($("#tSV").val());
  t += parseInt($("#tI").val());
  t += parseInt($("#tASEx").val());
  t += parseInt($("#tT").val());
  t += parseInt($("#tD").val());
  t += parseInt($("#tH").val());
  t += parseInt($("#tCI").val());
  t += parseInt($("#tTh").val());
  t += parseInt($("#tCO").val());
  t += parseInt($("#tO").val());
  //alert(t);
  $("#subTotal").val(t);
   document.getElementById('calcTotalDigit').innerHTML ="<b>"+ t +" </b> ";
   document.getElementById('finalTotalDigit').innerHTML ="<b>"+ t +" </b> ";
  // display in word
  NumToWord(t,'totalInWord');
  NumToWord(t,'calcTotalWord');
});
</script>
<!-- Digit to word conversion -->
 <script  type="text/javascript">
      function onlyNumbers(evt) {
    var e = event || evt; // For trans-browser compatibility
    var charCode = e.which || e.keyCode;

    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
}

function NumToWord(inputNumber, outputControl) {
    var str = new String(inputNumber)
    var splt = str.split("");
    var rev = splt.reverse();
    var once = ['Zero', ' One', ' Two', ' Three', ' Four', ' Five', ' Six', ' Seven', ' Eight', ' Nine'];
    var twos = ['Ten', ' Eleven', ' Twelve', ' Thirteen', ' Fourteen', ' Fifteen', ' Sixteen', ' Seventeen', ' Eighteen', ' Nineteen'];
    var tens = ['', 'Ten', ' Twenty', ' Thirty', ' Forty', ' Fifty', ' Sixty', ' Seventy', ' Eighty', ' Ninety'];

    numLength = rev.length;
    var word = new Array();
    var j = 0;

    for (i = 0; i < numLength; i++) {
        switch (i) {

            case 0:
                if ((rev[i] == 0) || (rev[i + 1] == 1)) {
                    word[j] = '';
                }
                else {
                    word[j] = '' + once[rev[i]];
                }
                word[j] = word[j];
                break;

            case 1:
                aboveTens();
                break;

            case 2:
                if (rev[i] == 0) {
                    word[j] = '';
                }
                else if ((rev[i - 1] == 0) || (rev[i - 2] == 0)) {
                    word[j] = once[rev[i]] + " Hundred ";
                }
                else {
                    word[j] = once[rev[i]] + " Hundred and";
                }
                break;

            case 3:
                if (rev[i] == 0 || rev[i + 1] == 1) {
                    word[j] = '';
                }
                else {
                    word[j] = once[rev[i]];
                }
                if ((rev[i + 1] != 0) || (rev[i] > 0)) {
                    word[j] = word[j] + " Thousand";
                }
                break;

                
            case 4:
                aboveTens();
                break;

            case 5:
                if ((rev[i] == 0) || (rev[i + 1] == 1)) {
                    word[j] = '';
                }
                else {
                    word[j] = once[rev[i]];
                }
                if (rev[i + 1] !== '0' || rev[i] > '0') {
                    word[j] = word[j] + " Lakh";
                }
                 
                break;

            case 6:
                aboveTens();
                break;

            case 7:
                if ((rev[i] == 0) || (rev[i + 1] == 1)) {
                    word[j] = '';
                }
                else {
                    word[j] = once[rev[i]];
                }
                if (rev[i + 1] !== '0' || rev[i] > '0') {
                    word[j] = word[j] + " Crore";
                }                
                break;

            case 8:
                aboveTens();
                break;

            default: break;
        }
        j++;
    }

    function aboveTens() {
        if (rev[i] == 0) { word[j] = ''; }
        else if (rev[i] == 1) { word[j] = twos[rev[i - 1]]; }
        else { word[j] = tens[rev[i]]; }
    }

    word.reverse();
    var finalOutput = '';
    for (i = 0; i < numLength; i++) {
        finalOutput = finalOutput + word[i];
    }
    document.getElementById(outputControl).innerHTML ="<b>"+ finalOutput +" Only.</b> ";
 

}
</script>
<!-- Digit to word end -->


<!--Including the js files-->
<script type="text/javascript" src="../../resources/js/jquery.js"></script>
<script type="text/javascript" src="../../resources/js/jquery.min.js"></script>
<script type="text/javascript" src="../../resources/js/jquery-ui.js"></script>
<script type="text/javascript" src="../../resources/jquery-ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="../../resources/js/modal.js"></script>

<script language="javascript" type="text/javascript">
    function CallPrint(id) {
        var prtContent = document.getElementById(id);
        var WinPrint = window.open();
        WinPrint.document.write(prtContent.innerHTML);
        WinPrint.document.close();
        WinPrint.focus();
        WinPrint.print();
        WinPrint.close();
        prtContent.innerHTML = strOldOne;
    }
</script>

<style type="text/css">
  .overline {
    width: auto;
    border-top: 2px dotted black;
}
</style>
<!--Page Endings-->
    </div>
    </div>
    </div>
    </body>
</html>