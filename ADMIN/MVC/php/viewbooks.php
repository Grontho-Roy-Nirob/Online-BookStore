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

<div class="table-container">
<table >
<tr>
    <th>Image</th>
    <th>Title</th>
    <th>Author</th>
    <th>Price</th>
    <th>Discount</th>
    <th>Final</th>
    <th>Qty</th>
    <th>Category</th>
    <th>Description</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php
if ($books && $books->num_rows > 0) {
    while ($row = $books->fetch_assoc()) {
        $id = (int)$row['id'];
        ?>
        <tr id="row-<?php echo $id; ?>">

        <td>
            <img src="../../../USER/MVC/Picture/<?php echo $row['image']; ?>" width="70">
        </td>

        <td>
            <input type="text" id="title-<?php echo $id; ?>"
                   value="<?php echo $row['title']; ?>">
        </td>

        <td>
            <input type="text" id="author-<?php echo $id; ?>"
                   value="<?php echo $row['author']; ?>">
        </td>

        <td>
            <input type="text" id="price-<?php echo $id; ?>"
                   value="<?php echo $row['price']; ?>"
                   oninput="calcFinalUpdate(<?php echo $id; ?>)">
        </td>

        <td>
            <input type="text" id="discount-<?php echo $id; ?>"
                   value="<?php echo $row['discount']; ?>"
                   oninput="calcFinalUpdate(<?php echo $id; ?>)">
        </td>

        <td>
            <input type="text" id="final-<?php echo $id; ?>"
                   value="<?php echo $row['final_price']; ?>" readonly>
        </td>

       <td>
  
     <?php 
            $qty = (int)$row['quantity'];
            $lowStock = $qty <= 2;
        ?>
            <input type="text" id="quantity-<?php echo $id; ?>"
                value="<?php echo $qty; ?>"
                style="<?php echo $lowStock ? 'border: 2px solid red; color: red;' : ''; ?>">
            <?php if ($lowStock) { ?>
                <span style="color: red; font-weight: bold; margin-left: 5px;">Low Stock!</span>
            <?php } ?>
        </td>

