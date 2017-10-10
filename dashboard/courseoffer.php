<?php
include($_SERVER['DOCUMENT_ROOT'].'/se/templates/dashboardsidebar.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/bll/bll.courseoffer.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/dal/dal.course.php');


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
  <h3> </h3>
    <!--Input part -->
  <div class="row">
    <div class="col-lg-12">
    
      <!--This form submit to self as session retrive data 
      no need to add action since included once bll.courseoffer.php-->
      
      <form class="form-group" id="terms" method="POST">
        <label for="terms">Select a Term</label>
        <select class="form form-control" name="term_select_submit" required onchange="this.form.submit()";>  
        <option value="null"> Select a term </option>
         <?php
          $bllCourseOffer = new BLLCourseOffer;
          $result = $bllCourseOffer->offeredTermInfo();
          echo $result;
         ?>

         </select>
      </form>
      <form class="form-group" method="POST">
        <label for="courses">Select Courses for

         <?php
          if(isset($_SESSION['term_select_submited'])) 
          {
            $result = $bllCourseOffer->offeredTermInfoById($_SESSION['term_select_submited']);
            echo $result;
          }
          
         ?>
         </label>
        
         <?php
          if(isset($_SESSION['term_select_submited']))
          {
            $dalCourse = new DALCourse;
            $result = $dalCourse->getyByOfferedTerm($_SESSION['term_select_submited']);
            $post = "<select class='form form-control' name='courses' required multiple size='8'>  ";
            while ($res = mysqli_fetch_assoc($result))
            {
              $post.= '<option value='.$res['id'].'>';
              $post.= $res["prefix"].' '.$res['courseNo'];
              $post.= ' -> '.$res["courseTitle"];
              $post.= ' -> '.$res["credit"];
              $post.= '</option>';
            }
            $post.= " </select>";
            echo $post;  

            $id = '<input  type="text"  name="offered_term_id" value="'.$_SESSION['term_select_submited'].'" style="display: none";>';
            echo $id;

          }
         ?>
        
         <input type="submit" class="btn btn-primary pull-right" name="insert_submit_courseoffer" value="Submit" >
      </form>
   
    </div>
    <!--Display offered course-->
    <div class="col-lg-12">
    <form class="form-group" method="POST">
      <label>Offered Courses in

         <?php
          if(isset($_SESSION['term_select_submited'])) 
          {
            $result = $bllCourseOffer->offeredTermInfoById($_SESSION['term_select_submited']);
            echo $result;
          }
          
         ?>
         </label>
      
       <?php
        $post = "<select class='form form-control' name='courses' required multiple size='8'>  ";
          if(isset($_SESSION['term_select_submited']))
          {
            $dalCourse = new DALCourse;
            $result = $dalCourse->getyByOfferedCourse($_SESSION['term_select_submited']);
           
            while ($res = mysqli_fetch_assoc($result))
            {
              $post.= '<option value='.$res['id'].'>';
              $post.= $res["prefix"].' '.$res['courseNo'];
              $post.= ' -> '.$res["courseTitle"];
              $post.= ' -> '.$res["credit"];
              $post.= '</option>';
            }
            $post.= " </select>";
            echo $post;  
            $id = '<input  type="text"  name="offered_term_id" value="'.$_SESSION['term_select_submited'].'" style="display: none";>';
            echo $id;

            unset($_SESSION['term_select_submited']);

          }
         ?>
         <input type="submit" class="btn btn-primary pull-right" name="remove_submit_courseoffer" value="Remove" >
         </form>
      </div>
    </div>
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
