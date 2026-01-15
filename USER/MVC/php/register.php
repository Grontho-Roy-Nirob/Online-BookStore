<?php
include "../Db/dbregister.php";

$username = $password = "";
$usernameError = $passwordError = "";
$success = $error = "";
$valid_username = "";

function test_input($data) {
    return trim($data);
}