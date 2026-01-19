<?php
session_start();
include("../../../USER/MVC/Db/dbregister.php");

if (!isset($_SESSION["username"]) || !str_starts_with($_SESSION["username"], "@admin")) {
    header("Location: ../../USER/MVC/php/index.php");
    exit();
}

$categoryList = [];
$catSql = "SELECT id, name FROM categories ORDER BY name ASC";
$catResult = $conn->query($catSql);

if ($catResult && $catResult->num_rows > 0) {
    while ($c = $catResult->fetch_assoc()) {
        $categoryList[$c['id']] = $c['name'];
    }
}

$bookSql = "SELECT * FROM books ORDER BY id DESC";
$books = $conn->query($bookSql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book List</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../Css/viewbooks.css">
</head>

<body>

<h2 class="book-list-title">Book List</h2>
<a href="admindashboard.php" class="back-dashboard">Back to Dashboard</a><br><br>
<a href="bookmodification.php" class="btn-add-book">Add New Book</a><br><br>

