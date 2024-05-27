<?php
include("../includes/config.php");
include("../includes/functions.php");

redirectIfNotLoggedIn();
if (!isManager()) {
    header("Location: ../index.php");
    exit();
}

// Fetch statistics data
$start_date = $_POST['start_date'] ?? date('Y-m-d');
$end_date = $_POST['end_date'] ?? date('Y-m-d');

// Fetch Room Occupancy Data
$occupancy_query = "SELECT rooms.name, COUNT(rentals.id) as rentals_count
                    FROM rentals
                    JOIN rooms ON rentals.room_id = rooms.id
                    WHERE rentals.start_time BETWEEN ? AND ?
                    GROUP BY rooms.name";
$occupancy_stmt = $db->prepare($occupancy_query);
$occupancy_stmt->bind_param('ss', $start_date, $end_date);
$occupancy_stmt->execute();
$occupancy_result = $occupancy_stmt->get_result();
$occupancy_data = $occupancy_result->fetch_all(MYSQLI_ASSOC);

// Fetch Equipment Rentals Data
$income_query = "SELECT equipment.name, COUNT(rentals.id) as rentals_count
                 FROM rentals
                 JOIN equipment ON rentals.equipment_id = equipment.id
                 WHERE rentals.start_time BETWEEN ? AND ?
                 GROUP BY equipment.name";
$income_stmt = $db->prepare($income_query);
$income_stmt->bind_param('ss', $start_date, $end_date);
$income_stmt->execute();
$income_result = $income_stmt->get_result();
$income_data = $income_result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Statistics</title>
    <link rel="stylesheet" type="text/css" href="../css/manager_style.css">
</head>
<body>
    <div class="header">
        <h1>View Statistics</h1>
    </div>
    <div class="container">
        <h2>Statistics from <?php echo htmlspecialchars($start_date); ?> to <?php echo htmlspecialchars($end_date); ?></h2>
        <form method="POST" action="">
            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" value="<?php echo htmlspecialchars($start_date); ?>" required>
            <label for="end_date">End Date:</label>
            <input type="date" name="end_date" value="<?php echo htmlspecialchars($end_date); ?>" required>
            <input type="submit" value="View Statistics">
        </form>

        <h3>Room Occupancy</h3>
        <table>
            <tr>
                <th>Room</th>
                <th>Number of Rentals</th>
            </tr>
            <?php foreach ($occupancy_data as $data): ?>
            <tr>
                <td><?php echo htmlspecialchars($data['name']); ?></td>
                <td><?php echo htmlspecialchars($data['rentals_count']); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>

        <h3>Equipment Rentals</h3>
        <table>
            <tr>
                <th>Equipment</th>
                <th>Number of Rentals</th>
            </tr>
            <?php foreach ($income_data as $data): ?>
            <tr>
                <td><?php echo htmlspecialchars($data['name']); ?></td>
                <td><?php echo htmlspecialchars($data['rentals_count']); ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <a href="manager_dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
