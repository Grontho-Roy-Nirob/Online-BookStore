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
