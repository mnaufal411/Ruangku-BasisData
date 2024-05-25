<?php
require '../includes/config.php';
require '../includes/functions.php';

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
</head>
<body>
    <div class="header">
        <h1>Admin Dashboard</h1>
    </div>
    <div class="container">
        <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
        <ul>
            <li><a href="manage_users.php">Manage Users</a></li>
            <li><a href="manage_rooms.php">Manage Rooms</a></li>
            <li><a href="manage_equipment.php">Manage Equipment</a></li>
        </ul>
        <a href="../logout.php">Logout</a>
    </div>
</body>
</html>
