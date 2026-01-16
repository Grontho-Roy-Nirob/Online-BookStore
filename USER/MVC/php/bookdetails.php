<?php
session_start();
include("../Db/dbregister.php");

/* Check if id exists + numeric */
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: booklist.php");
    exit();
}

$id = (int)$_GET['id'];

/* Simple OOP query (NO prepared statement) */
$result = $conn->query(
    "SELECT * FROM books 
     WHERE id=$id AND status='available' 
     LIMIT 1"
);

$book = ($result && $result->num_rows == 1)
        ? $result->fetch_assoc()
        : null;

if (!$book) {
    header("Location: booklist.php");
    exit();
}

/* Decide availability */
$isAvailable = (strtolower($book['status']) === "available");
$inStock = ((int)$book['quantity'] > 0);
$canBuy = $isAvailable && $inStock;
?>