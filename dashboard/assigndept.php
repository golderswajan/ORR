<?php
include($_SERVER['DOCUMENT_ROOT'].'/se/templates/dashboardsidebar.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/dal/dal.university.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/dal/dal.department.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/se/dashboard/bll/bll.assigndept.php');

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
      
      <form class="form-group" id="varsity" method="POST" action="bll/bll.assigndept.php" onsubmit="reload_page();">
        <label for="varsity">Select an University</label>
        
        <div class="input-group">
        <select class="form form-control" name="university" required";>  
         <?php
          $obj = new DALUniversity;
          $result = $obj->get();
          
          while($res = mysqli_fetch_assoc($result))
          {
              $post= '<option value='.$res['id'].'>';
              $post.= $res['name'];
              $post.= '</option>';
              echo $post;
          }

         ?>

         </select>
        <div class="input-group-btn">
        <!-- Load selected university departments-->
        <button class="btn btn-default" type="submit" name="search_dept" data-toggle="tooltip" title="Click to see Departments"><i class="glyphicon glyphicon-search"></i></button>
        </div>
        </div>

        <label >Select Departments</label>
        
         <?php
         
            $obj = new DALDepartment;
            $result = $obj->get();
            $post = "<select class='form form-control' name='departments[]'  multiple size='10'> ";
            while ($res = mysqli_fetch_assoc($result))
            {
              $post.= '<option value='.$res['id'].'>';
              $post.= $res['name'];
              $post.= '</option>';
            }
            $post.= " </select>";
            echo $post; 
         ?>
        
         <input type="submit" class="btn btn-primary pull-right" name="insert_submit" value="Submit" >
      </form>
   
    </div>
  </div>

<!--Data display-->
<div></div>
<div id="table">
    <table class="table">
        <thead>
            <tr id="varsitydept_list">
                <th colspan="2"><h3 class="text-center">University-Department Information</h3></th>
            </tr>
              <tr id="varsitydept_list">
                <th >Department</th>
                <th class="text-right"> Delete</th>
            </tr>
        </thead>
        <tbody>
           <?php
            $bllAssignDept = new BLLAssignDept;
           if(isset($_SESSION['varsityId']))
           {

             $obj = $bllAssignDept->showBySelection($_SESSION['varsityId']);
             echo $obj;
             session_unset($_SESSION['varsityId']);
           }
           else
           {
             /* $obj = $bllAssignDept->show();
              echo $obj;*/

              echo "<tr><td><h3>Select an University to see the Departments.</h3></td></tr>";
           }
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
