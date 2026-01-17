<?php
session_start();
include "../../../USER/MVC/Db/dbregister.php";

/* Check admin login */
if (!isset($_SESSION['username']) || !str_starts_with($_SESSION['username'], '@admin')) {
    header("Location: ../../USER/MVC/php/login.php");
    exit();
}


$sql = "SELECT username, password FROM registereduser";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - View Users</title>
    <link rel="stylesheet" href="../Css/viewuserr.css">
</head>
<body>
    <h2 class="title">Registered Users</h2>

    <table>
    <tr>
        <th>Username</th>
        <th>Hashed Password</th>
    </tr>

    

</body>
</html>