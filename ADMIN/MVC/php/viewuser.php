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
    <link rel="stylesheet" href="../Css/viewuser.css">
</head>
<body>
    <h2 class="title">Registered Users</h2>

    <table>
        <tr>
            <th>Username</th>
            <th>Hashed Password</th>
        </tr>

        <?php
        if ($result && $result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['username'] . "</td>";
                echo "<td class='hash'>" . $row['password'] . "</td>";
                echo "</tr>";
            }

        } else {
            echo "<tr>";
            echo "<td colspan='2' class='no-data'>No users found</td>";
            echo "</tr>";
        }
        ?>
    </table>

</body>
</html>