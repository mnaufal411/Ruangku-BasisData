<?php
include("includes/config.php");
include("includes/functions.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($db, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] === 'Admin') {
            header("Location: admin/admin_dashboard.php");
        } elseif ($user['role'] === 'Operator') {
            header("Location: operator/operator_dashboard.php");
        } elseif ($user['role'] === 'Manajer') {
            header("Location: manager/manager_dashboard.php");
        }
        exit();
    } else {
        $error = "Invalid username or password";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/login_style.css">
</head>
<body>
    <div class="container">
        <div class="login-box">
            <h1>Ruangku Login</h1>
            <p>Please log in to continue!</p>
            <form method="POST" action="">
                <div class="textbox">
                    <input type="text" id="username" name="username" placeholder="Username" required>
                </div>
                <div class="textbox">
                    <input type="password" id="password" name="password" placeholder="Password" required>
                    <span class="toggle-password" onclick="togglePassword()">&#128065;</span> 
                </div>
                <input type="submit" class="btn" value="Login">
            </form>
            <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
            <a href="index.php" class="back-btn">&larr; Back</a>
        </div>
    </div>
    <script>
        function togglePassword() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
</body>
</html>
