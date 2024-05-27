<?php
include("../includes/config.php");
include("../includes/functions.php");

redirectIfNotLoggedIn();
if (!isOperator()) {
    header("Location: ../index.php");
    exit();
}

$equipment = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    $query = "SELECT * FROM equipment WHERE id NOT IN (
        SELECT equipment_id FROM rentals WHERE
        (? < end_time AND ? > start_time)
    )";

    $stmt = $db->prepare($query);
    $stmt->bind_param('ss', $start_time, $end_time);
    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($item = $result->fetch_assoc()) {
        $equipment[] = $item;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Search Equipment</title>
    <link rel="stylesheet" type="text/css" href="../css/op_style.css">
</head>
<body>
    <div class="header">
        <h1>Search Equipment</h1>
    </div>
    <div class="container">
        <form method="POST" action="">
            <input type="datetime-local" name="start_time" required>
            <input type="datetime-local" name="end_time" required>
            <input type="submit" value="Search">
        </form>
        <?php if ($equipment): ?>
            <h2>Available Equipment</h2>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                </tr>
                <?php foreach ($equipment as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td><?php echo htmlspecialchars($item['description']); ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <p>No available equipment found.</p>
        <?php endif; ?>
        <a href="operator_dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
