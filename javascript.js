function validateForm() {
    var x = document.forms["searchform"]["searchbox"].value;
    if (x == "") {
        alert("No result found, please check your search.");
        return false;
    }
}
