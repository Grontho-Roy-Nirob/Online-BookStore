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

