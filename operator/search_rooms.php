<?php
include("../includes/config.php");
include("../includes/functions.php");

redirectIfNotLoggedIn();
if (!isOperator()) {
    header("Location: ../index.php");
    exit();
}

$rooms = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $capacity = $_POST['capacity'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    
    $stmt = $db->prepare("SELECT * FROM rooms WHERE capacity >= ? AND id NOT IN (
        SELECT room_id FROM rentals WHERE
        (? < end_time AND ? > start_time)
    )");
    $stmt->bind_param('iss', $capacity, $start_time, $end_time);
    $stmt->execute();
    $rooms = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Search Rooms</title>
    <link rel="stylesheet" type="text/css" href="../css/op_style.css">
</head>
<body>
    <div class="header">
        <h1>Search Rooms</h1>
    </div>
    <div class="container">
        <form method="POST" action="">
            <input type="number" name="capacity" placeholder="Minimum Capacity" required>
            <input type="datetime-local" name="start_time" required>
            <input type="datetime-local" name="end_time" required>
            <input type="submit" value="Search">
        </form>
        <?php if ($rooms): ?>
            <h2>Available Rooms</h2>
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
        <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <p>No available rooms found.</p>
        <?php endif; ?>
        <a href="operator_dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
