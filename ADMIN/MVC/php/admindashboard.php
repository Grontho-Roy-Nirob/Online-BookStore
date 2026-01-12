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
    
</body>
</html>