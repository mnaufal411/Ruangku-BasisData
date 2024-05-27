<?php
include("../includes/config.php");
include("../includes/functions.php");

redirectIfNotLoggedIn();
if (!isManager()) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manager Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../css/manager_style.css">
</head>
<body>
    <div class="header">
        <h1>Manager Dashboard</h1>
    </div>
    <div class="container">
        <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
        <ul>
            <li><a href="manage_rates.php">Manage Rates</a></li>
            <li><a href="view_rooms.php">View Rooms</a></li>
            <li><a href="view_equipment.php">View Equipment</a></li>
            <li><a href="view_reports.php">View Reports</a></li>
            <li><a href="view_statistics.php">View Statistics</a></li>
        </ul>
        <a href="../logout.php">Logout</a>
    </div>
</body>
</html>
