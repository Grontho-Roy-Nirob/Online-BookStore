<?php
session_start();
include "../Db/dbregister.php";

/* Security checks */
if (!isset($_SESSION['username']) || !isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    header("Location: checkout.php");
    exit();
}

/* Get form data */
$username = $_SESSION['username'];
$name     = trim($_POST['name'] ?? "");
$mobile   = trim($_POST['mobile'] ?? "");
$address  = trim($_POST['address'] ?? "");
$method   = $_POST['payment_method'] ?? "";

$payment_number = "";

/* Payment validation */
if ($method == "bKash") {
    if (empty($_POST['bkash_number'])) {
        $_SESSION['checkout_error'] = "bKash number is required";
        header("Location: checkout.php");
        exit();
    }
    $payment_number = $_POST['bkash_number'];
}

if ($method == "Nagad") {
    if (empty($_POST['nagad_number'])) {
        $_SESSION['checkout_error'] = "Nagad number is required";
        header("Location: checkout.php");
        exit();
    }
    $payment_number = $_POST['nagad_number'];
}

/* STEP 1: Stock check + real price/title from DB */
$total = 0;
$verifiedCart = []; // will store final title/price for each item

foreach ($_SESSION['cart'] as $item) {

    $book_id = (int)($item['id'] ?? 0);
    $qty     = (int)($item['qty'] ?? 0);

    if ($book_id <= 0 || $qty <= 0) {
        $_SESSION['checkout_error'] = "Invalid cart item found!";
        header("Location: checkout.php");
        exit();
    }

    $r = $conn->query("SELECT title, final_price, quantity, status
                       FROM books
                       WHERE id=$book_id
                       LIMIT 1");

    $b = ($r && $r->num_rows == 1) ? $r->fetch_assoc() : null;

    if (!$b || strtolower($b['status']) != "available") {
        $_SESSION['checkout_error'] = "One or more books are not available!";
        header("Location: checkout.php");
        exit();
    }

    if ((int)$b['quantity'] < $qty) {
        $_SESSION['checkout_error'] = "Stock not enough for: " . $b['title'];
        header("Location: checkout.php");
        exit();
    }

    $price = (float)$b['final_price'];
    $title = $b['title'];

    $total += ($price * $qty);

    // save verified values for step 3
    $verifiedCart[] = [
        "book_id" => $book_id,
        "qty"     => $qty,
        "price"   => $price,
        "title"   => $title
    ];
}

$total = round($total, 2);

/* Escape order info */
$u  = $conn->real_escape_string($username);
$n  = $conn->real_escape_string($name);
$m  = $conn->real_escape_string($mobile);
$a  = $conn->real_escape_string($address);
$pm = $conn->real_escape_string($method);
$pn = $conn->real_escape_string($payment_number);

/* STEP 2: Insert order */
$sql = "INSERT INTO orders 
        (username, name, mobile, address, payment_method, payment_number, total_amount)
        VALUES 
        ('$u', '$n', '$m', '$a', '$pm', '$pn', '$total')";

if (!$conn->query($sql)) {
    die("Order insert failed: " . $conn->error);
}

$order_id = (int)$conn->insert_id;
