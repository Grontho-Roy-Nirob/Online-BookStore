<?php
session_start();

$action = $_POST['action'] ?? '';
$id     = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$removed = 0; // 0=no, 1=yes

// CANCEL (clear all)
if ($action === "cancel") {
    $_SESSION['cart'] = [];
    echo "success|0|0|1";
    exit();
}
