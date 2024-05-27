<?php
include("../includes/config.php");
include("../includes/functions.php");

redirectIfNotLoggedIn();
if (!isManager()) {
    header("Location: ../index.php");
    exit();
}

$start_date = $_POST['start_date'] ?? date('Y-m-d');
$end_date = $_POST['end_date'] ?? date('Y-m-d');

$query = "SELECT * FROM rentals WHERE start_time BETWEEN ? AND ?";
$stmt = $db->prepare($query);
$stmt->bind_param('ss', $start_date, $end_date);
$stmt->execute();
$result = $stmt->get_result();
$rentals = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Reports</title>
    <link rel="stylesheet" type="text/css" href="../css/manager_style.css">
</head>
<body>
    <div class="header">
        <h1>View Reports</h1>
    </div>
    <div class="container">
        <h2>Transaction Reports</h2>
        <form method="POST" action="">
            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" value="<?php echo $start_date; ?>" required>
            <label for="end_date">End Date:</label>
            <input type="date" name="end_date" value="<?php echo $end_date; ?>" required>
            <input type="submit" value="View Report">
        </form>
        <table>
            <tr>
                <th>Customer</th>
                <th>Room</th>
                <th>Equipment</th>
                <th>Start Time</th>
                <th>End Time</th>
            </tr>
            <?php foreach ($rentals as $rental): ?>
            <tr>
                <td>
                    <?php
                    $customer_result = $db->query("SELECT name FROM customers WHERE id = {$rental['customer_id']}");
                    $customer = $customer_result->fetch_assoc();
                    echo htmlspecialchars($customer['name']);
                    ?>
                </td>
                <td>
                    <?php
                    $room_result = $db->query("SELECT name FROM rooms WHERE id = {$rental['room_id']}");
                    $room = $room_result->fetch_assoc();
                    echo htmlspecialchars($room['name']);
                    ?>
                </td>
                <td>
                    <?php
                    $equipment_result = $db->query("SELECT name FROM equipment WHERE id = {$rental['equipment_id']}");
                    $equipment = $equipment_result->fetch_assoc();
                    echo htmlspecialchars($equipment['name']);
                    ?>
                </td>
                <td><?php echo htmlspecialchars($rental['start_time']); ?></td>
                <td><?php echo htmlspecialchars($rental['end_time']); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <a href="manager_dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
