<?php
include("../includes/config.php");
include("../includes/functions.php");

redirectIfNotLoggedIn();
if (!isManager()) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'];
    $reference_id = $_POST['reference_id'];
    $rate = $_POST['rate'];

    $stmt = $db->prepare("INSERT INTO rates (type, reference_id, rate) VALUES (?, ?, ?)");
    $stmt->bind_param("sid", $type, $reference_id, $rate);
    $stmt->execute();

    header("Location: manage_rates.php");
    exit();
}

$rooms = $db->query("SELECT * FROM rooms")->fetch_all(MYSQLI_ASSOC);
$equipment = $db->query("SELECT * FROM equipment")->fetch_all(MYSQLI_ASSOC);
$rates = $db->query("SELECT * FROM rates")->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Rates</title>
    <link rel="stylesheet" type="text/css" href="../css/manager_style.css">
</head>
<body>
    <div class="header">
        <h1>Manage Rates</h1>
    </div>
    <div class="container">
        <h2>Add Rate</h2>
        <form method="POST" action="">
            <label for="type">Type:</label>
            <select name="type" required>
                <option value="Room">Room</option>
                <option value="Equipment">Equipment</option>
            </select>

            <label for="reference_id">Reference:</label>
            <select name="reference_id" required>
                <optgroup label="Rooms">
                    <?php foreach ($rooms as $room): ?>
                    <option value="<?php echo $room['id']; ?>"><?php echo $room['name']; ?></option>
                    <?php endforeach; ?>
                </optgroup>
                <optgroup label="Equipment">
                    <?php foreach ($equipment as $item): ?>
                    <option value="<?php echo $item['id']; ?>"><?php echo $item['name']; ?></option>
                    <?php endforeach; ?>
                </optgroup>
            </select>

            <label for="rate">Rate:</label>
            <input type="number" step="0.01" name="rate" required>
            
            <input type="submit" value="Add Rate">
        </form>

        <h2>Current Rates</h2>
        <table>
            <tr>
                <th>Type</th>
                <th>Reference</th>
                <th>Rate</th>
            </tr>
            <?php foreach ($rates as $rate): ?>
            <tr>
                <td><?php echo $rate['type']; ?></td>
                <td>
                    <?php
                    if ($rate['type'] == 'Room') {
                        $ref = $db->query("SELECT name FROM rooms WHERE id = {$rate['reference_id']}")->fetch_assoc();
                        echo $ref['name'];
                    } else {
                        $ref = $db->query("SELECT name FROM equipment WHERE id = {$rate['reference_id']}")->fetch_assoc();
                        echo $ref['name'];
                    }
                    ?>
                </td>
                <td><?php echo $rate['rate']; ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <a href="manager_dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
