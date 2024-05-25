<?php
require '../includes/config.php';
require '../includes/functions.php';

redirectIfNotLoggedIn();
if (!isAdmin()) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create'])) {
        $name = $_POST['name'];
        $capacity = $_POST['capacity'];
        $condition = $_POST['condition'];
        $stmt = $conn->prepare("INSERT INTO rooms (name, capacity, condition) VALUES (:name, :capacity, :condition)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':capacity', $capacity);
        $stmt->bindParam(':condition', $condition);
        $stmt->execute();
    } elseif (isset($_POST['update'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $capacity = $_POST['capacity'];
        $condition = $_POST['condition'];
        $stmt = $conn->prepare("UPDATE rooms SET name = :name, capacity = :capacity, condition = :condition WHERE id = :id");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':capacity', $capacity);
        $stmt->bindParam(':condition', $condition);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $stmt = $conn->prepare("DELETE FROM rooms WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}

$rooms = $conn->query("SELECT * FROM rooms")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Rooms</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
</head>
<body>
    <div class="header">
        <h1>Manage Rooms</h1>
    </div>
    <div class="container">
        <h2>Create Room</h2>
        <form method="POST" action="">
            <input type="text" name="name" placeholder="Room Name" required>
            <input type="number" name="capacity" placeholder="Capacity" min="7" max="20" required>
            <textarea name="condition" placeholder="Condition" required></textarea>
            <input type="submit" name="create" value="Create" class="btn">
        </form>
        <h2>Existing Rooms</h2>
        <table class="table">
            <tr>
                <th>Name</th>
                <th>Capacity</th>
                <th>Condition</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($rooms as $room) { ?>
            <tr>
                <td><?php echo $room['name']; ?></td>
                <td><?php echo $room['capacity']; ?></td>
                <td><?php echo $room['condition']; ?></td>
                <td>
                    <form method="POST" action="" style="display:inline-block;">
                        <input type="hidden" name="id" value="<?php echo $room['id']; ?>">
                        <input type="text" name="name" value="<?php echo $room['name']; ?>" required>
                        <input type="number" name="capacity" value="<?php echo $room['capacity']; ?>" min="7" max="20" required>
                        <textarea name="condition" required><?php echo $room['condition']; ?></textarea>
                        <input type="submit" name="update" value="Update" class="btn">
                    </form>
                    <form method="POST" action="" style="display:inline-block;">
                        <input type="hidden" name="id" value="<?php echo $room['id']; ?>">
                        <input type="submit" name="delete" value="Delete" class="btn">
                    </form>
                </td>
            </tr>
            <?php } ?>
        </table>
        <a href="admin_dashboard.php" class="btn">Back to Dashboard</a>
    </div>
</body>
</html>
