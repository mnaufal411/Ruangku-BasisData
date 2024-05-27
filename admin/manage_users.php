<?php
include("../includes/config.php");
include("../includes/functions.php");

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

redirectIfNotLoggedIn();
if (!isAdmin()) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create'])) {
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $password = password_hash(mysqli_real_escape_string($db, $_POST['password']), PASSWORD_BCRYPT);
        $role = mysqli_real_escape_string($db, $_POST['role']);
        $stmt = $db->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password, $role);
        $stmt->execute();
    } elseif (isset($_POST['update'])) {
        $id = mysqli_real_escape_string($db, $_POST['id']);
        $username = mysqli_real_escape_string($db, $_POST['username']);
        $password = password_hash(mysqli_real_escape_string($db, $_POST['password']), PASSWORD_BCRYPT);
        $role = mysqli_real_escape_string($db, $_POST['role']);
        $stmt = $db->prepare("UPDATE users SET username = ?, password = ?, role = ? WHERE id = ?");
        $stmt->bind_param("sssi", $username, $password, $role, $id);
        $stmt->execute();
    } elseif (isset($_POST['delete'])) {
        $id = mysqli_real_escape_string($db, $_POST['id']);
        $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}

$users = $db->query("SELECT * FROM users")->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    <link rel="stylesheet" type="text/css" href="../css/mannage_admin.css">
</head>
<body>
    <div class="header">
        <h1>Kelola Pengguna</h1>
        <a href="admin_dashboard.php" class="btn">Back to Dashboard</a>
    </div>
    <div class="container">
        <h2>Create User</h2>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required>
            <div class="password-wrapper">
                <input type="password" name="password" placeholder="Password" required>
                <span class="toggle-password" onclick="togglePassword(this)">👁️</span>
            </div>
            <select name="role">
                <option value="Admin">Admin</option>
                <option value="Operator">Operator</option>
                <option value="Manajer">Manajer</option>
            </select>
            <input type="submit" name="create" value="Create" class="btn">
        </form>
        <h2>Existing Users</h2>
        <table class="table">
            <tr>
                <th>Username</th>
                <th>Password</th>
                <th>Role</th>
                <th>Update/Delete</th>
            </tr>
            <?php foreach ($users as $user) { ?>
            <tr>
                <form method="POST" action="">
                    <td>
                        <input type="text" name="username" value="<?php echo $user['username']; ?>" required>
                    </td>
                    <td>
                        <div class="password-wrapper">
                            <input type="password" name="password" value="<?php echo $user['password']; ?>" required>
                            <span class="toggle-password" onclick="togglePassword(this)">👁️</span>
                        </div>
                    </td>
                    <td>
                        <select name="role">
                            <option value="Admin" <?php if ($user['role'] == 'Admin') echo 'selected'; ?>>Admin</option>
                            <option value="Operator" <?php if ($user['role'] == 'Operator') echo 'selected'; ?>>Operator</option>
                            <option value="Manajer" <?php if ($user['role'] == 'Manajer') echo 'selected'; ?>>Manajer</option>
                        </select>
                    </td>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                        <input type="submit" name="update" value="Update" class="btn">
                        <input type="submit" name="delete" value="Delete" class="btn">
                    </td>
                </form>
            </tr>
            <?php } ?>
        </table>
    </div>
    <script>
        function togglePassword(elem) {
            var input = elem.previousElementSibling;
            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        }
    </script>
</body>
</html>
