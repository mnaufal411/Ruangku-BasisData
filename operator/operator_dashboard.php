<?php
include("../includes/config.php");
include("../includes/functions.php");

redirectIfNotLoggedIn();
if (!isOperator()) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Operator Dashboard</title>
    <link rel="stylesheet" type="text/css" href="../css/op_style.css">
</head>
<body>
    <div class="header">
        <h1>Operator Dashboard</h1>
    </div>
    <div class="container">
        <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
        <ul>
            <li><a href="search_rooms.php">Search Rooms</a></li>
            <li><a href="search_equipment.php">Search Equipment</a></li>
            <li><a href="process_rental.php">Process Rental</a></li>
        </ul>
        <a href="../logout.php">Logout</a>
    </div>
</body>
</html>
