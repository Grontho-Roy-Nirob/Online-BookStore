<?php
session_start();
include("../Db/dbregister.php"); // $conn

/* CHECK LOGIN */
if (!isset($_SESSION['username'])) {
    echo "login";
    exit();
}

/* CREATE CART */
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
if ($id <= 0) {
    echo "invalid";
    exit();
}

/*Check stock + availability from DB */
$res = $conn->query("SELECT title, final_price, status, quantity 
                     FROM books 
                     WHERE id=$id 
                     LIMIT 1");

$book = ($res && $res->num_rows == 1) ? $res->fetch_assoc() : null;

if (!$book) {
    echo "notfound";
    exit();
}

if (strtolower($book['status']) != "available") {
    echo "notavailable";
    exit();
}

if ((int)$book['quantity'] <= 0) {
    echo "outofstock";
    exit();
}

/*If already in cart, make sure cart qty won't exceed stock */
$found = false;

foreach ($_SESSION['cart'] as &$item) {
    if ((int)$item['id'] === $id) {

        if ((int)$item['qty'] >= (int)$book['quantity']) {
            echo "limit"; // can't add more than stock
            exit();
        }

        $item['qty']++;
        // also refresh title/price from DB (security)
        $item['title'] = $book['title'];
        $item['price'] = (float)$book['final_price'];

        $found = true;
        break;
    }
}
