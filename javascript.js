function validateForm() {
    var x = document.forms["searchform"]["searchbox"].value;
    if (x == "") {
        alert("Empty search-field");
        return false;
    }
}

