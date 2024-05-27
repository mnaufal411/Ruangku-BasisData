<?php
include("../includes/config.php");
include("../includes/functions.php");

redirectIfNotLoggedIn();
if (!isManager()) {
    header("Location: ../index.php");
    exit();
}

$result = mysqli_query($db, "SELECT * FROM rooms");
$rooms = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Rooms</title>
    <link rel="stylesheet" type="text/css" href="../css/manager_style.css">
</head>
<body>
    <div class="header">
        <h1>View Rooms</h1>
    </div>
    <div class="container">
        <h2>Room Information</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>Capacity</th>
                <th>Condition</th>
            </tr>
            <?php foreach ($rooms as $room): ?>
            <tr>
                <td><?php echo htmlspecialchars($room['name']); ?></td>
                <td><?php echo htmlspecialchars($room['capacity']); ?></td>
                <td><?php echo htmlspecialchars($room['condition']); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <a href="manager_dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
