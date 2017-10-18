
<?php
  require_once('./includes/functions.php');
  require_once('./dashboard/bll/bll.assigndept.php');
  include('templates/header.php');

  // Need authentication

  // Detect user type
  $userType = $functions->getUserType($userId);
  // Generate key=>value according to user type
   $fields = "";
  
  if($userType=='student')
  {
    // Get * from user
    $studentSpecialInfo = $functions->getStudentSpecialInfo($userId);


      while ($info = mysqli_fetch_assoc($studentSpecialInfo)) 
      {

         $bllAssignDept = new BLLAssignDept;
         // Convert id to name(versity,dept)
         $varsityDeptName =$bllAssignDept->getVarsityDeptName($info['varsityDeptId']);
         $fields = array('Student Id' => $info['studentId'],
        'Batch'=> $info['batch'],
        'University'=> $varsityDeptName['varsity'],
        'Department'=> $varsityDeptName['dept']

        );
      }
    
   

  }
  else if($userType=='teacher')
  {
    $teacherSpecialInfo = $functions->getTeacherSpecialInfo($userId);
    while ($info = mysqli_fetch_assoc($teacherSpecialInfo)) 
    {
       $bllAssignDept = new BLLAssignDept;
       // Convert id to name(versity,dept)
       $varsityDeptName =$bllAssignDept->getVarsityDeptName($info['varsityDeptId']);

       $fields =array(
      'Designation' => $info['designation'],
      'University'=> $varsityDeptName['varsity'],
      'Department'=> $varsityDeptName['dept'],
      'Office'=> $info['office'],
      'Home'=> $info['address'],
      'Website'=> $info['website']
      );

    }
     
  }
  else
  {
    echo "userType undefined";
  }
?>

<!--Show Additional info-->
<div class="panel-heading alert-success">
  <h3 class="panel-title">Additional Information</h3>
</div>
<table class="table table-user-information">
    <tbody>

    <?php
      $post= "";
      if($fields==null)
      {
        $post.= "<tr>";
        $post.= " <td >Data not found</td>";
        $post.= "</tr>";
      }
      else
      {
        foreach ($fields as $key => $value) {
        $post.= "<tr>";
        $post.= " <td >".$key."</td>";
        $post.= " <td id=".$key.">".$value."</td>";
        $post.= "</tr>";
      }
      }
      echo $post;
    ?>

    </tbody>
</table>