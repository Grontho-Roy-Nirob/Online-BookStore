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
