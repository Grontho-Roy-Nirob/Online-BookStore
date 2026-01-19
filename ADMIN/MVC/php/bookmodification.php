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


    if ($title === '') 
        $error = "Title cannot be empty";
    else if ($author === '') 
        $error = "Author cannot be empty";
    else if ($price === '' || !is_numeric($price) || floatval($price) <= 0) 
        $error = "Enter a valid price";
    else if ($discount === '' || !is_numeric($discount) || floatval($discount) < 0 || floatval($discount) > 100) 
        $error = "Discount must be between 0 and 100";
    else if ($final_price === '' || !is_numeric($final_price) || floatval($final_price) < 0) 
        $error = "Invalid final price";
    else if ($quantity === '' || !is_numeric($quantity) || intval($quantity) < 1) 
        $error = "Quantity must be at least 1";
    else if ($description === '') 
        $error = "Description cannot be empty";
    else if ($category === '') 
        $error = "Please select a category";

