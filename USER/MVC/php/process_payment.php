<?php
session_start();
include "../Db/dbregister.php";

/* Security checks */
if (!isset($_SESSION['username']) || !isset($_SESSION['cart']) || count($_SESSION['cart']) == 0) {
    header("Location: checkout.php");
    exit();
}
