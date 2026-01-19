<?php
session_start();
include("../../../USER/MVC/Db/dbregister.php");

if (!isset($_SESSION["username"]) || !str_starts_with($_SESSION["username"], "@admin")) {
    header("Location: ../../../USER/MVC/php/login.php");
    exit();
}

$orders = $conn->query("SELECT * FROM orders ORDER BY order_id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Customer Orders</title>
    <link rel="stylesheet" href="../Css/order.css">
</head>
<body>
    
<div class="container">
    <h2 class="page-title" >Customer Orders</h2>
    
</body>
</html>