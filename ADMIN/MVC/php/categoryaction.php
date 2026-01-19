<?php
session_start();
include("../../../USER/MVC/Db/dbregister.php");

if (!isset($_SESSION['username']) || !str_starts_with($_SESSION['username'], '@admin')) {
    header("Location: ../../USER/MVC/php/login.php");
    exit();
}

$action = $_POST['action'] ?? '';

if ($action === "add") {
    $name = trim($_POST['name'] ?? '');

    if ($name === "") {
        exit("Category name required");
    }

    $sql = "INSERT INTO categories(name) VALUES('$name')";
    if ($conn->query($sql)) echo "success";
    else echo "Failed";
    exit();
}