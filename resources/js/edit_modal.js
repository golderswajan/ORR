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

// Reload after modal submit
function reload_page()
{
	 setTimeout(function () {
        location.reload()
    }, 300);
}