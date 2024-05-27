<?php
include("../includes/config.php");
include("../includes/functions.php");

redirectIfNotLoggedIn();
if (!isManager()) {
    header("Location: ../index.php");
    exit();
}

$result = mysqli_query($db, "SELECT * FROM equipment");
$equipment = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Equipment</title>
    <link rel="stylesheet" type="text/css" href="../css/manager_style.css">
</head>
<body>
    <div class="header">
        <h1>View Equipment</h1>
    </div>
    <div class="container">
        <h2>Equipment Information</h2>
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
        <a href="manager_dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>
