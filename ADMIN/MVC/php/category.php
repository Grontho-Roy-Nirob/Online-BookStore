<?php
session_start();
include("../../../USER/MVC/Db/dbregister.php");

if (!isset($_SESSION["username"]) || !str_starts_with($_SESSION["username"], "@admin")) {
    header("Location: ../../USER/MVC/php/index.php");
    exit();
}

$cats = $conn->query("SELECT * FROM categories ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Category Management</title>
    <link rel="stylesheet" href="../Css/category.css">
</head>
<body>

<div style="text-align:center;">
    <h2>Category Management</h2>
</div>

<div class="box">
    <h3>Add Category</h3>
    <input type="text" id="cat_name" placeholder="Category Name">
    <button onclick="addCategory()">Add Category</button>
</div>

<hr>



</body>
</html>