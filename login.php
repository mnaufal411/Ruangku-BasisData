<?php
require 'includes/config.php';
require 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $password === $user['password']) { // Tidak menggunakan hash untuk password
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        header("Location: index.php");
        exit();
    } else {
        $error = "Invalid username or password.";
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
                    <span class="toggle-password" onclick="togglePassword()">&#128065;</span> <!-- Tombol untuk melihat/menyembunyikan password -->
                </div>
                <input type="submit" class="btn" value="Login">
            </form>
            <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
            <a href="index.php" class="back-btn">&larr; Back</a> <!-- Tombol "Back" -->
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
