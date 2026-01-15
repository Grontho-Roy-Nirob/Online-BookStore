<?php
session_start();
include("../Db/dbregister.php"); // $conn = new mysqli(...)

$search = "";
$category = "";

/* Fetch categories (OOP) */
$catResult = $conn->query("SELECT * FROM categories");

/* Only show AVAILABLE books to users */
$query = "SELECT * FROM books WHERE status='available' AND quantity > 0";

/* Search filter */
if (isset($_GET['search']) && trim($_GET['search']) != "") {
    $search = trim($_GET['search']);
    $s = $conn->real_escape_string($search);
    $query .= " AND (title LIKE '%$s%' OR author LIKE '%$s%')";
}

/* Category filter */
if (isset($_GET['category']) && trim($_GET['category']) != "") {
    $category = trim($_GET['category']);
    $c = $conn->real_escape_string($category);
    $query .= " AND category_id = '$c'";
}

$query .= " ORDER BY id DESC";

/* Fetch books (OOP) */
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book List - BookZone</title>
    <link rel="stylesheet" href="../Css/booklist.css">
</head>
<body>

<h2 class="page-title">All Books</h2>

<!-- SEARCH -->
<form method="get" class="search-section">
    <div class="search-container">
        <input type="text" name="search" class="search-bar"
               placeholder="Search books..."
               value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit" class="search-btn">
            <img src="../Picture/search.png" alt="search">
        </button>
    </div>
</form>