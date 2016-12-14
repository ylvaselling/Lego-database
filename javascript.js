function validateForm() {
    var x = document.forms["searchform"]["searchbox"].value;
    if (x == "") {
        alert("No result found, please check your search.");
        return false;
    }
}

<!-- The Modal -->
<div id='myModal' class='modal'>
  <span class='close'>&times;</span>
  <img class='modal-content' id='img01'>
  <div id='caption'></div>
</div>


// Get the modal
var modal = document.getElementById('myModal');

// Get the image and insert it inside the modal - use its 'alt' text as a caption
var img = document.getElementById('$SetID');
var modalImg = document.getElementById('img01');
var captionText = document.getElementById('caption');
img.onclick = function(){
    modal.style.display = 'block';
    modalImg.src = this.src;
    captionText.innerHTML = this.alt;
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName('close')[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() { 
    modal.style.display = 'none';
}
