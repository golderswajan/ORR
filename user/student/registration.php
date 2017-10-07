<?php 
  $studentId=150206;
  if(isset($_SESSION['student']))
  {

    $email = $_SESSION['student'];
    echo "Email: $email<br>";
    $studentId = $utility->getStudentId($email);
    echo "StudentId: $studentId";
  }
  
 ?>
<div id="table">
    <table class="table">
        <thead>
            <tr id="registeredTermId_list">
                <th colspan="2"><h3 class="text-center"> Information</h3></th>
            </tr>
              <tr id="registeredTermId_list">

                <th >Id</th>
                <th >OfferedTermId</th>
                <th >Studnent Id</th>

            </tr>
        </thead>
        <tbody>
           <?php
           require_once("bll/bll.registration.php");
           $content = $bllRegistration->show($studentId);
           echo $content;
           ?>
        </tbody>
        <tfoot>
            <tr>
              <td> Current Registered Term Id </td>
                <td>
                   <?php
                     require_once("bll/bll.registration.php");
                     $Current = $bllRegistration->getCurrentRegisteredTermId($studentId);
                     echo $Current;
                    ?>
                </td>
            </tr>
        </tfoot>
    </table>
</div>