<?php
session_start();
include("../Db/dbregister.php"); // $conn = new mysqli(...)

$search = "";
$category = "";

/* Fetch categories (OOP) */
$catResult = $conn->query("SELECT * FROM categories");

/* Only show AVAILABLE books to users */
$query = "SELECT * FROM books WHERE status='available' AND quantity > 0";
