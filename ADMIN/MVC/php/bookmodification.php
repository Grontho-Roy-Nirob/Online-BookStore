<?php
include("../../../USER/MVC/Db/dbregister.php");

$categories = [];
$sql = "SELECT id, name FROM categories ORDER BY name ASC";
$result = $conn->query($sql);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}

$title = $author = $price = $discount = $final_price = $quantity = $description = $category = $status = "";
$error = $success = "";

if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $title       = trim($_POST['title']);
    $author      = trim($_POST['author']);
    $price       = trim($_POST['price']);
    $discount    = trim($_POST['discount']);
    $final_price = trim($_POST['final_price']);
    $quantity    = trim($_POST['quantity']);
    $description = trim($_POST['description']);
    $category    = $_POST['category'] ?? '';
    $status      = $_POST['status'] ?? 'Available';
