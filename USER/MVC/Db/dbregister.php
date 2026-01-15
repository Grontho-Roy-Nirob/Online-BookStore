<?php
$host = "localhost";
$registereduser = "root";
$pass = "";
$dbname = "Bookstore";

$conn = new mysqli($host, $registereduser, $pass, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
