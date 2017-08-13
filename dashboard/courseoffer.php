<?php
include($_SERVER['DOCUMENT_ROOT'].'/se/templates/dashboardsidebar.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/bll/bll.courseoffer.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/dal/dal.course.php');



if(isset($_SESSION['message']))
{
  $msg = "<div class='alert alert-success'>";
  $msg .= ($_SESSION['message']);
  $msg .= "</div>";
  echo $msg;
  session_unset($_SESSION['message']);
}
?>

<div class="content">
  <h3> </h3>
    <!--Input part -->
  <div class="row">
    <div class="col-lg-12">
      <form>
      <div class="form-group">
        <label for="terms">Select a Term</label>
        <select class="form form-control" name="term_select_submit" required onchange="this.form.submit()>  
         <?php
          $obj = new BLLCourseOffer;
          $result = $obj->offeredTermInfo();
          echo $result;
         
         ?>
         </select>
      </div>
      <div class="form-group">
        <label for="_course">Select Courses</label>
        <select class="form form-control" name="courses" required multiple>  
         <?php
          if($_SESSION['term_select_submited'])
          {
            $obj = new DALCourse;
            $result = $obj->get();
            $post = "";
            while ($res = mysqli_fetch_assoc($result))
            {
              $post.= '<option value='.$res['id'].'>';
              $post.= $res["prefix"].' '.$res['course_no'];
              $post.= ' -> '.$res["course_title"];
              $post.= ' -> '.$res["credit"];
              $post.= '</tr>';
            }
            echo $post;  
          }
         ?>
         </select>
      </div>
    </form>
    </div>
  </div>



  <!--Display part -->
  <div class="row">
   <div class="col-lg-12">
     <label for="_term">Offerd Terms</label>
     <form action="bll/bll.courseoffer.php" id="_term">
         <select class="form form-control" name="term_select" onchange="this.form.submit()">  
         <option> Select a term </option>
         <?php
          $obj = new BLLCourseOffer;
          $result = $obj->offeredTermInfo();
          echo $result;
         
         ?>
         </select>
     </form>
   </div>
   </div>
   <div class="row">
     <div class="col-lg-12">
     <label for="_course">Available Courses Under Selected Term</label>
        <table id="_course" class="table table-condensed">
        <tr>
          <th>Cours No</th>
          <th>Title</th>
          <th>Credit</th>
        </tr>
         <?php

            if(isset($_SESSION['term_submitted']))
            {

            $obj = new DALCourse;
            $result = $obj->get();
            $post = "";
            while ($res = mysqli_fetch_assoc($result))
            {
              $post.= '<tr>';
              $post.= '<td  style="display: none">'.$res['id'].'</td>';
              $post.= '<td >'.$res["prefix"].' '.$res['course_no'].'</td>';
              $post.= '<td >'.$res["course_title"].'</td>';
              $post.= '<td >'.$res["credit"].'</td>';
              $post.= '</tr>';
            }
            echo $post;
          }
         ?>

     </table>
     </div>
   </div>
</div>


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
