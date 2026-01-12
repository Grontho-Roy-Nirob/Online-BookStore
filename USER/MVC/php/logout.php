<?php
session_start();

session_unset();
session_destroy();
setcookie("username", "", time() - 3600, "/"); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logout</title>
    <link rel="stylesheet" href="../Css/logout.css"> 
</head>
<body>

<div class="container">
    <p id="logout-message">You have been logged out. Redirecting to dashboard...</p>
</div>