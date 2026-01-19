<?php
session_start();
include("../../../USER/MVC/Db/dbregister.php");

if (!isset($_SESSION['username']) || !str_starts_with($_SESSION['username'], "@admin")) {
    header("Location: ../../USER/MVC/php/index.php");
    exit();
}

if (isset($_GET['ajax']) && $_GET['ajax'] == 1) {

    $from = trim($_GET['from'] ?? '');
    $to   = trim($_GET['to'] ?? '');
    $where = [];

    if ($from !== '') {
            $where[] = "DATE(o.order_date) >= '$from'";
        }
        if ($to !== ''){
            $where[] = "DATE(o.order_date) <= '$to'";
        }  

        $whereSQL = !empty($where) ? "WHERE ".implode(" AND ", $where) : '';

        $sql = "
        SELECT 
                o.order_id, 
                o.name, 
                o.order_date, 
                o.total_amount,
                i.book_title, 
                i.price, 
                i.quantity
            FROM orders o
            JOIN order_items i ON o.order_id = i.order_id
            LEFT JOIN books b ON i.book_id = b.id
            $whereSQL ORDER BY o.order_date DESC";

        $result = $conn->query($sql);


