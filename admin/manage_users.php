<?php
require '../includes/config.php';
require '../includes/functions.php';

redirectIfNotLoggedIn();
if (!isAdmin()) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create'])) {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $role = $_POST['role'];
        $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (:username, :password, :role)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);
        $stmt->execute();
    } elseif (isset($_POST['update'])) {
        $id = $_POST['id'];
        $username = $_POST['username'];
        $role = $_POST['role'];
        $stmt = $conn->prepare("UPDATE users SET username = :username, role = :role WHERE id = :id");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $stmt = $conn->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}

$users = $conn->query("SELECT * FROM users WHERE role != 'Admin'")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Users</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
</head>
<body>
    <div class="header">
        <h1>Manage Users</h1>
    </div>
    <div class="container">
        <h2>Create User</h2>
        <form method="POST" action="">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <select name="role">
                <option value="Operator">Operator</option>
                <option value="Manajer">Manajer</option>
            </select>
            <input type="submit" name="create" value="Create" class="btn">
        </form>
        <h2>Existing Users</h2>
        <table class="table">
            <tr>
                <th>Username</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($users as $user) { ?>
            <tr>
                <td><?php echo $user['username']; ?></td>
                <td><?php echo $user['role']; ?></td>
                <td>
                    <form method="POST" action="" style="display:inline-block;">
                        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                        <input type="hidden" name="username" value="<?php echo $user['username']; ?>">
                        <select name="role">
                            <option value="Operator" <?php if ($user['role'] == 'Operator') echo 'selected'; ?>>Operator</option>
                            <option value="Manajer" <?php if ($user['role'] == 'Manajer') echo 'selected'; ?>>Manajer</option>
                        </select>
                        <input type="submit" name="update" value="Update" class="btn">
                    </form>
                    <form method="POST" action="" style="display:inline-block;">
                        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                        <input type="submit" name="delete" value="Delete" class="btn">
                    </form>
                </td>
            </tr>
            <?php } ?>
        </table>
        <a href="admin_dashboard.php" class="btn">Back to Dashboard</a>
    </div>
</body>
</html>
