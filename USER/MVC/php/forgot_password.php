<?php
session_start();
include "../Db/dbregister.php";

$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username'] ?? "");
    $newPass  = trim($_POST['new_password'] ?? "");

    if ($username == "" || $newPass == "") {
        $msg = "All fields are required!";
    } else {

        // Decide table
        $table = (str_starts_with($username, "@admin")) ? "admin" : "registereduser";

        $u = $conn->real_escape_string($username);

        // Check user exists
        $res = $conn->query("SELECT username FROM $table WHERE username='$u' LIMIT 1");

        if ($res && $res->num_rows == 1) {

            if ($table == "admin") {
                // admin plain password
                $p = $conn->real_escape_string($newPass);
                $conn->query("UPDATE admin SET password='$p' WHERE username='$u'");
            } else {
                // user hashed password
                $hashed = password_hash($newPass, PASSWORD_DEFAULT);
                $p = $conn->real_escape_string($hashed);
                $conn->query("UPDATE registereduser SET password='$p' WHERE username='$u'");
            }

            $msg = "Password updated successfully!";
        } else {
            $msg = "Username not found!";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="../Css/login.css">
</head>
<body>
<div class="container">
    <h2>Forgot Password</h2>

    <form method="post">
        <input type="text" name="username" placeholder="Username">
        <input type="password" name="new_password" placeholder="New Password">
        <button type="submit">Reset Password</button>
    </form>

    <p><?php echo $msg; ?></p>
    <p><a href="login.php">Back to Login</a></p>
</div>
</body>
</html>
