<?php
include("../includes/config.php");
include("../includes/functions.php");

redirectIfNotLoggedIn();
if (!isAdmin()) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    <link rel="stylesheet" type="text/css" href="../css/admin_dashboard.css">
</head>
<body>
    <div class="header">
        <button class="menu-button" onclick="toggleMenu()">☰</button>
        <h1>Admin Dashboard</h1>
    </div>
    <div id="menu" class="menu">
        <a href="manage_users.php">Kelola pengguna</a>
        <a href="manage_rooms.php">Kelola Ruangan</a>
        <a href="manage_equipment.php">Kelola Alat-alat</a>
        <a href="../logout.php">Logout</a>
        <a href="admin_dashboard.php" class="back-button">Back to Dashboard</a>
    </div>
    <div class="container">
        <div class="grid-container">
            <div class="grid-item">
                <h2>Manage Users</h2>
                <form method="POST" action="manage_users.php">
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <select name="role">
                        <option value="Admin">Admin</option>
                        <option value="Operator">Operator</option>
                        <option value="Manajer">Manajer</option>
                    </select>
                    <input type="submit" name="create" value="Create">
                </form>
            </div>
            <div class="grid-item">
                <h2>Existing Users</h2>
                <table>
                    <tr>
                        <th>Username</th>
                        <th>Role</th>
                    </tr>
                    <?php
                    $query = "SELECT * FROM users";
                    $result = mysqli_query($db, $query);
                    while ($user = mysqli_fetch_assoc($result)) {
                        echo "<tr><td>{$user['username']}</td><td>{$user['role']}</td></tr>";
                    }
                    ?>
                </table>
            </div>
            <div class="grid-item">
                <h2>Manage Rooms</h2>
                <form method="POST" action="manage_rooms.php">
                    <input type="text" name="name" placeholder="Room Name" required>
                    <input type="number" name="capacity" placeholder="Capacity" required>
                    <input type="text" name="condition" placeholder="Condition" required>
                    <input type="submit" name="create" value="Create">
                </form>
            </div>
            <div class="grid-item">
                <h2>Existing Rooms</h2>
                <table>
                    <tr>
                        <th>Name</th>
                        <th>Capacity</th>
                        <th>Condition</th>
                    </tr>
                    <?php
                    $query = "SELECT * FROM rooms";
                    $result = mysqli_query($db, $query);
                    while ($room = mysqli_fetch_assoc($result)) {
                        echo "<tr><td>{$room['name']}</td><td>{$room['capacity']}</td><td>{$room['condition']}</td></tr>";
                    }
                    ?>
                </table>
            </div>
            <div class="grid-item">
                <h2>Manage Equipment</h2>
                <form method="POST" action="manage_equipment.php">
                    <input type="text" name="name" placeholder="Equipment Name" required>
                    <input type="text" name="description" placeholder="Description" required>
                    <input type="submit" name="create" value="Create">
                </form>
            </div>
            <div class="grid-item">
                <h2>Existing Equipment</h2>
                <table>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                    </tr>
                    <?php
                    $query = "SELECT * FROM equipment";
                    $result = mysqli_query($db, $query);
                    while ($equipment = mysqli_fetch_assoc($result)) {
                        echo "<tr><td>{$equipment['name']}</td><td>{$equipment['description']}</td></tr>";
                    }
                    ?>
                </table>
            </div>
        </div>
    </div>
    <script>
        function toggleMenu() {
            var menu = document.getElementById("menu");
            if (menu.style.left === "0px") {
                menu.style.left = "-250px";
            } else {
                menu.style.left = "0px";
            }
        }
    </script>
</body>
</html>
