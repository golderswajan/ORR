<?php
include($_SERVER['DOCUMENT_ROOT'].'/wpl/templates/dashboardsidebar.php');
//echo $_SERVER['DOCUMENT_ROOT'];


if(isset($_SESSION['message']))
{
  alert($_SESSION['message']);
}
?>

<div id="table">
    <table class="table">
        <thead>
            <tr id="library_list">
                <th colspan="2"><h3 class="text-center">Library Information</h3></th>
            </tr>
              <tr id="library_list">
                <th >Name</th>
                <th >Address</th>
                <th >Type</th>
                <th> Edit</th>
                <th> Delete</th>
            </tr>
        </thead>
        <tbody>
           <?php
           require_once("bll/bll.library.php");
           $object->showLibraries();
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

<!-- Add new Modal-->
 <link rel="stylesheet" href="/wpl/resources/css/modal.css">

 <button id="myBtn" class="btn btn-primary">Crate New Library</button>

<!-- Modal for insertion -->
 <!-- The Modal -->
 <div id="myModal" class="modal">
   <!-- Modal content -->
   <div class="modal-content">
     <div class="modal-header">
       <span class="close">&times;</span>
       <h2>Add New Library</h2>    </div>

     <div class="modal-body">
      <form action="bll/bll.library.php" method="POST">
      
         <span class="badge badge-success">Name</span>
         <input id="name" type="text" class="form-control" name="name" placeholder="Name of the Library" required>

         <span class="badge badge-success">Address</span>
         <input id="address" type="text" class="form-control" name="address" placeholder="Where it is located?" required>

        <span class="badge badge-success">Select type</span>
        <select class="form-control" id="sel1" name="type">
          <option value="Public">Public</option>
          <option value="Seminar">Seminar</option>
          <option value="Personal">Personal</option>
          <option value="Others">Others</option>
        </select>
        <br>
        <input type="submit" name="submit_insert" value="Submit" class="btn btn-primary pull-right"  onclick="document.getElementById('new').style.display='none'" >
       </form>
       <div >
         <br>
       </div>
      
   </div>

 </div>
 </div>

 <!-- Modal for updating -->
 <!-- The Modal -->
 <div id="modalUpdate" class="modal">
   <!-- Modal content -->
   <div class="modal-content">
     <div class="modal-header">
       <span class="close">&times;</span>
       <h2>Edit Library</h2>    </div>

     <div class="modal-body">
      <form action="bll/bll.library.php" method="POST">
         <input id="id_update" type="text"  name="id" style="display: none";>
          
         <span class="badge badge-success">Name</span>
         <input id="name_update" type="text" class="form-control" name="name" placeholder="Name of the Library" required>

         <span class="badge badge-success">Address</span>
         <input id="address_update" type="text" class="form-control" name="address" placeholder="Where it is located?" required>

        <span class="badge badge-success">Select type</span>
        <select class="form-control" id="type_update" name="type">
          <option value="Public">Public</option>
          <option value="Seminar">Seminar</option>
          <option value="Personal">Personal</option>
          <option value="Others">Others</option>
        </select>
        <br>

        <input type="submit" name="submit_update" value="Submit" class="btn btn-primary pull-right"  onclick="document.getElementById('modalUpdate').style.display='none'" >
       </form>
       <div >
         <br>
       </div>

 </div>
 </div>
 </div>

<script type="text/javascript" src="/wpl/resources/js/jquery.min.js"></script>
<script type="text/javascript">
 // Get the modal
var modal = document.getElementById('myModal');
var modalUpdate = document.getElementById('modalUpdate');
// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];
var span1 = document.getElementsByClassName("close")[1];

// When the user clicks the button, open the modal 
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";

}
span1.onclick = function() {
    modalUpdate.style.display = "none";
}



// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal || event.target == modalUpdate) {
        modal.style.display = "none";
        modalUpdate.style.display = "none";
    }
     
}



// Function that call from bll to edit items

function EditLibrary(id)
{
  modalUpdate.style.display = "block"; // show the modal

  // Data retriving form table to modal
   var $row = $('#row_id'+id+'').closest("tr");

      $Name = $row.find("td:nth-child(1)"); 
      $Address = $row.find("td:nth-child(2)"); 
      $Type = $row.find("td:nth-child(3)"); 

      $('#id_update').attr('value',id);
      $('#name_update').attr('value',$($Name).text());
      $('#address_update').attr('value',$($Address).text());
      $('#type_update').attr('SelectedIndex',$($Type).text());


    // alert($($Name).text());  

  /* Loop to access all td in tr
  $.each($tds, function() {                
       alert($(this).text());     
  });*/

}

</script>
<!--Modal end-->
<!--Page Endings-->
    </div>
    </div>
    </div>
    </body>
</html>
