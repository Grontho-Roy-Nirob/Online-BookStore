<?php
include "../Db/dbregister.php";

$username = $password = "";
$usernameError = $passwordError = "";
$success = $error = "";
$valid_username = "";

function test_input($data) {
    return trim($data);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    if (empty($_POST["username"])) {
        $usernameError = "Username is required";
    } else {
        $username = test_input($_POST["username"]);

        if (!preg_match("/^[a-zA-Z]/", $username)) {
            $usernameError = "Username must start with a letter";
        } elseif (!preg_match("/^[a-zA-Z .\-]+$/", $username)) {
            $usernameError = "Only letters, dot, dash allowed";
        } elseif (str_word_count($username) < 2) {
            $usernameError = "Username must contain at least two words";
        }
    }

    if (empty($_POST["password"])) {
        $passwordError = "Password is required";
    } else {
        $password = test_input($_POST["password"]);

        if (strlen($password) < 6) {
            $passwordError = "Password must be at least 6 characters";
        } elseif (!preg_match("/[A-Z]/", $password)) {
            $passwordError = "Must contain one uppercase letter";
        } elseif (!preg_match("/[a-z]/", $password)) {
            $passwordError = "Must contain one lowercase letter";
        } elseif (!preg_match("/[0-9]/", $password)) {
            $passwordError = "Must contain one number";
        }
    }

    if (empty($usernameError) && empty($passwordError)) {

        $hashPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO registereduser (username, password)
                VALUES ('$username', '$hashPassword')";

        if ($conn->query($sql)) {
            $success = "Registration complete. Redirecting to login page...";
            $valid_username = $username;
            $username = $password = ""; 

            
        } else {
            $error = "Error: " . $conn->error;
        }
    }
}
?>