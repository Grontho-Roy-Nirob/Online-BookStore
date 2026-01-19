<?php
session_start();
include("../../../USER/MVC/Db/dbregister.php");

if (!isset($_SESSION["username"]) || !str_starts_with($_SESSION["username"], "@admin")) {
    header("Location: ../../USER/MVC/php/index.php");
    exit();
}

$cats = $conn->query("SELECT * FROM categories ORDER BY id DESC");
?>