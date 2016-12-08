function validateForm() {
    var x = document.forms["searchform"]["searchbox"].value;
    if (x == "") {
        alert("Please search for Lego!");
        return false;
    }
}
