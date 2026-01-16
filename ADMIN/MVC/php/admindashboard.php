<?php
session_start();
$loggedUser = "";

if (isset($_SESSION["username"])) {
    $loggedUser = $_SESSION["username"];
} elseif (isset($_COOKIE["username"])) {
    $loggedUser = $_COOKIE["username"];
}

if (empty($loggedUser) || !str_starts_with($loggedUser, "@admin")) {
    header("Location: ../../USER/MVC/php/index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <div class="container">

    <!-- LEFT MENU -->
    <div class="sidebar">
        <h2>Admin Menu</h2>
        <hr>
        <a href="../php/viewuser.php">View Registered Users</a>
        <a href="../php/order.php">View Customer Orders</a>
        <a href="../php/bookmodification.php">Book Modification</a>
        <a href="../php/sales.php">Generate Sales Report</a>
        <a href="../php/category.php">Category Management</a>
    </div>


    
</body>
</html>