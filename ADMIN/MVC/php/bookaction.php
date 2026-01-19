<?php
session_start();
include("../../../USER/MVC/Db/dbregister.php");

/* ===== ADMIN PROTECTION ===== */
if (!isset($_SESSION["username"]) || !str_starts_with($_SESSION["username"], "@admin")) {
    header("Location: ../../USER/MVC/php/index.php");
    exit();
}

$action = $_POST['action'] ?? '';

function cleanStatus($status) {
    if ($status !== "Available" && $status !== "Unavailable") {
        return "Available";
    }
    return $status;
}

if ($action === "update") {
    $id = $_POST['id'];

    $title       = $_POST['title'];
    $author      = $_POST['author'];
    $price       = $_POST['price'];
    $discount    = $_POST['discount'];
    $final       = $_POST['final_price'];
    $quantity    = $_POST['quantity'];
    $description = $_POST['description'];
    $category    = $_POST['category'];
    $status      = cleanStatus($_POST['status']);

    $sql = "UPDATE books SET
        title='$title',
        author='$author',
        price='$price',
        discount='$discount',
        final_price='$final',
        quantity='$quantity',
        description='$description',
        status='$status',
        category_id='$category'
        WHERE id=$id";

    echo $conn->query($sql) ? "Updated" : "Failed";
    exit();
}
