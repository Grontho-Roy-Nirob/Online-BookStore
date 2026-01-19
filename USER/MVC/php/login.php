<?php
session_start();

$loginRedirectMsg = "";

if (isset($_SESSION['login_error'])) {
    $loginRedirectMsg = $_SESSION['login_error'];
    unset($_SESSION['login_error']);
}

if (isset($_SESSION["username"])) {
    if (str_starts_with($_SESSION["username"], "@admin")) {
        header("Location: ../../../ADMIN/MVC/php/admindashboard.php"); 
    } else {
        header("Location: ../php/index.php");
    }
    exit();
}

include "../Db/dbregister.php"; 


$username = "";
$usernameError = $passwordError = "";
$successMessage = $errorMessage = "";

function test_input($data) {
    return trim($data);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {


    if (empty($_POST["username"])) {
        $usernameError = "Username is required";
    } else {
        $username = test_input($_POST["username"]);
    }

    if (empty($_POST["password"])) {
        $passwordError = "Password is required";
    } else {
        $password = test_input($_POST["password"]);
    }

    if (empty($usernameError) && empty($passwordError)) {

        if (str_starts_with($username, "@admin")) {

            $sql = "SELECT * FROM admin WHERE username='$username'";
            $result = $conn->query($sql);

            if ($result && $result->num_rows == 1) {
                $row = $result->fetch_assoc();

                if ($password === $row['password']) {

                    $_SESSION["username"] = $username;
                    setcookie("username", $username, time() + 86400, "/");

                    $successMessage = "Admin login successful! Redirecting...";
                    echo "<script>
                        setTimeout(function() {
                            window.location.href = '../../../ADMIN/MVC/php/admindashboard.php';
                        }, 2000);
                    </script>";

                } else {
                    $errorMessage = "Invalid admin password";
                }
            } else {
                $errorMessage = "Admin username not found";
            }

        } else {
            $sql = "SELECT * FROM registereduser WHERE username='$username'";
            $result = $conn->query($sql);

            if ($result && $result->num_rows == 1) {
                $row = $result->fetch_assoc();

                if (password_verify($password, $row['password'])) {

                    $_SESSION["username"] = $username;
                    setcookie("username", $username, time() + 86400, "/");

                    $successMessage = "User login successful! Redirecting...";
                    echo "<script>
                        setTimeout(function() {
                            window.location.href = '../php/index.php';
                        }, 1000);
                    </script>";

                } else {
                    $errorMessage = "Invalid password";
                }
            } else {
                $errorMessage = "Username not found";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../Css/login.css"> 
</head>
<body>

<div class="container">
    <h1>Login</h1>

    <?php
    if (!empty($loginRedirectMsg)) {
    echo "<p class='errormsg'>$loginRedirectMsg</p>";}
    ?>

    <form method="post" action="">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>">
            <span class="error"><?php echo $usernameError; ?></span>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password">
            <span class="error"><?php echo $passwordError; ?></span>
        </div>

        <button type="submit">Login</button>
    </form>

    <?php
    if (!empty($successMessage)) {
        echo "<p class='successmsg'>$successMessage</p>";
    }

    if (!empty($errorMessage)) {
        echo "<p class='errormsg'>$errorMessage</p>";
    }
    ?>
    
    <p style="margin-top:8px;">
        <a href="forgot_password.php">Forgot Password?</a>
    </p>

    <p class="register-text">
        Not registered yet? <a href="../php/register.php">Register here</a>
    </p>
</div>

</body>
</html>
