<?php
include($_SERVER['DOCUMENT_ROOT'].'/se/templates/dashboardsidebar.php');
require_once("bll/bll.approveuser.php");

if(isset($_SESSION['message']))
{
  $msg = "<div class='alert alert-success'>";
  $msg .= ($_SESSION['message']);
  $msg .= "</div>";
  echo $msg;
  unset($_SESSION['message']);
}
?>

<!-- User approval form-->
<form action="bll/bll.approveuser.php" method="POST" onsubmit="reload_page();">
<div id="table">
    <table class="table">
        <thead>
            <tr id="user_list">
                <th colspan="2"><h3 class="text-center">User Information</h3></th>
            </tr>
              <tr id="user_list">
                <th >User Name</th>
                <th >Email</th>
                <th >Role</th>
                <th  class="text-right"> Approve</th>
            </tr>
        </thead>
        <tbody>
           <?php
           $content = $bllApproveUser->show();
           echo $content;
           ?>
        </tbody>
        <tfoot>
            <tr>
              <td></td>
              <td></td>
              <td>
                <input type="submit" name="approveAll" value="Approve All" class="btn btn-primary pull-right">
              </td><td>
                <input type="submit" name="approve" value="Approve" class="btn btn-primary pull-right">
              </td>
            </tr>
        </tfoot>
    </table>
</div>
</form>
<!-- User approval form-->
<!--Including the js files-->
<script type="text/javascript" src="/se/resources/js/jquery.js"></script>
<script type="text/javascript" src="/se/resources/js/jquery.min.js"></script>
<script type="text/javascript" src="/se/resources/js/edit_modal.js"></script>
<script type="text/javascript" src="/se/resources/js/jquery-ui.js"></script>
<script type="text/javascript" src="/se/resources/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="/se/resources/js/confirm_delete.js"></script>


<script type="text/javascript">

<!--Page Endings-->
    </div>
    </div>
    </div>
    </body>
</html>
