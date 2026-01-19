<?php
session_start();
include("../../../USER/MVC/Db/dbregister.php");

if (!isset($_SESSION['username']) || !str_starts_with($_SESSION['username'], '@admin')) {
    header("Location: ../../USER/MVC/php/login.php");
    exit();
}

$action = $_POST['action'] ?? '';

if ($action === "add") {
    $name = trim($_POST['name'] ?? '');

    if ($name === "") {
        exit("Category name required");
    }

    $sql = "INSERT INTO categories(name) VALUES('$name')";
    if ($conn->query($sql)) echo "success";
    else echo "Failed";
    exit();
}

if ($action === "update") {
    $id = (int)($_POST['id'] ?? 0);
    $name = trim($_POST['name'] ?? '');

    if ($id <= 0 || $name === "") exit("Invalid data");

    $sql = "UPDATE categories SET name='$name' WHERE id=$id";
    if ($conn->query($sql)) echo "Updated";
    else echo "Failed";
    exit();
}

if ($action === "delete") {
    $id = (int)($_POST['id'] ?? 0);

    $conn->query("DELETE FROM books WHERE category_id = $id");

    $ok = $conn->query("DELETE FROM categories WHERE id = $id");
    echo $ok ? "Deleted" : "Error";
    exit();
}

echo "Invalid action";
?>