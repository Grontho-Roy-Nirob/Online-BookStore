function postData(url, data, callback) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            callback(this.responseText);
        }
    };
    xhttp.open("POST", url, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send(data);
}

function handleCartResponse(resText, id) {
    // expected: success|cartCount|total|removed
    var parts = resText.split("|");

    // safety check
    if (parts.length < 4) {
        console.log("Bad response:", resText);
        return;
    }

    var cartCount = parseInt(parts[1], 10);
    var total = parseFloat(parts[2]);
    var removed = (parts[3] === "1");

    document.getElementById("cartTotal").innerHTML = total.toFixed(2);

    if (removed) {
        var row = document.getElementById("row-" + id);
        if (row) row.remove();
    }

    if (cartCount === 0) {
        document.getElementById("emptyMsg").style.display = "block";
        document.getElementById("shopLink").style.display = "inline-block";
        var actions = document.getElementById("cartActions");
        if (actions) actions.style.display = "none";
    }
}
