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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($book['title']); ?> - Details</title>
    <link rel="stylesheet" href="../Css/bookdetails.css">
</head>
<body>

<a href="booklist.php" class="back-link">← Back to Book List</a>

<div class="details-container">

    <div class="book-image">
        <img src="../Picture/<?php echo htmlspecialchars($book['image']); ?>"
             alt="<?php echo htmlspecialchars($book['title']); ?>">
    </div>

    <div class="book-info">
        <h2><?php echo htmlspecialchars($book['title']); ?></h2>

        <p><b>Author:</b> <?php echo htmlspecialchars($book['author']); ?></p>

        <!-- Price -->
        <?php if ((float)$book['discount'] > 0) { ?>
            <p>
                <b>Original Price:</b>
                <span style="text-decoration: line-through; color:#888;">
                    ৳<?php echo number_format((float)$book['price'], 2); ?>
                </span>
            </p>

            <p><b>Discount:</b> <?php echo (int)$book['discount']; ?>%</p>

            <p class="final-price">
                <b>Final Price:</b>
                ৳<?php echo number_format((float)$book['final_price'], 2); ?>
            </p>
        <?php } else { ?>
            <p class="final-price">
                <b>Price:</b>
                ৳<?php echo number_format((float)$book['final_price'], 2); ?>
            </p>
        <?php } ?>

        <p><b>Status:</b> <?php echo htmlspecialchars($book['status']); ?></p>
        <p><b>Stock:</b> <?php echo (int)$book['quantity']; ?></p>

        <p class="description">
            <b>Description:</b><br>
            <?php echo nl2br(htmlspecialchars($book['description'])); ?>
        </p>

        <!-- ADD TO CART -->
        <form onsubmit="return addToCart(this);">
            <input type="hidden" name="id" value="<?php echo (int)$book['id']; ?>">
            <input type="hidden" name="title" value="<?php echo htmlspecialchars($book['title']); ?>">
            <input type="hidden" name="price" value="<?php echo (float)$book['final_price']; ?>">

            <button type="submit" class="cart-btn" <?php echo (!$canBuy ? "disabled" : ""); ?>>
                <?php echo $canBuy ? "Add to Cart" : "Out of Stock"; ?>
            </button>

            <p class="cartMsg" style="margin-top:6px; font-size:13px;"></p>
        </form>

    </div>
</div>

<script src="../Js/booklistajax.js"></script>
</body>
</html>