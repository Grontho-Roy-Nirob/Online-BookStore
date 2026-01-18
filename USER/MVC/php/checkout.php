<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link rel="stylesheet" href="../Css/checkout.css">

    <script>
        function togglePayment(method) {
            document.getElementById("bkashBox").style.display = "none";
            document.getElementById("nagadBox").style.display = "none";

            if (method === "bkash") {
                document.getElementById("bkashBox").style.display = "block";
            }
            if (method === "nagad") {
                document.getElementById("nagadBox").style.display = "block";
            }
        }
    </script>
</head>
<body>