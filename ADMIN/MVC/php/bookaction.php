<?php
session_start();
include("../../../USER/MVC/Db/dbregister.php");

/* ===== ADMIN PROTECTION ===== */
if (!isset($_SESSION["username"]) || !str_starts_with($_SESSION["username"], "@admin")) {
    header("Location: ../../USER/MVC/php/index.php");
    exit();
}

$action = $_POST['action'] ?? '';

function cleanStatus($status) {
    if ($status !== "Available" && $status !== "Unavailable") {
        return "Available";
    }
    return $status;
}
