function addCategory() {
    var name = document.getElementById("cat_name").value.trim();

    if (name === "") {
        alert("Category name cannot be empty!");
        return;
    }

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            if (this.responseText === "success") {
                alert("Category added!");
                location.reload();
            } else {
                alert(this.responseText);
            }
        }
    };
    xhttp.open("POST", "categoryaction.php", true);
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhttp.send("action=add&name=" + encodeURIComponent(name));
}
