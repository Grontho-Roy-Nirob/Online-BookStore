<?php
session_start();

$loginRedirectMsg = "";

if (isset($_SESSION['login_error'])) {
    $loginRedirectMsg = $_SESSION['login_error'];
    unset($_SESSION['login_error']);
}

if (isset($_SESSION["username"])) {
    if (str_starts_with($_SESSION["username"], "@admin")) {
        header("Location: ../../../ADMIN/MVC/php/admindashboard.php"); 
    } else {
        header("Location: ../php/index.php");
    }
    exit();
}

include "../Db/dbregister.php"; 


$username = "";
$usernameError = $passwordError = "";
$successMessage = $errorMessage = "";