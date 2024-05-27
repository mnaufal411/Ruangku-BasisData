<?php
include("../includes/config.php");
include("../includes/functions.php");

redirectIfNotLoggedIn();
if (!isAdmin()) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $capacity = $_POST['capacity'];
        $condition = $_POST['condition'];

        $stmt = $db->prepare("INSERT INTO rooms (id, name, capacity, `condition`) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $id, $name, $capacity, $condition);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['update'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $capacity = $_POST['capacity'];
        $condition = $_POST['condition'];

        $stmt = $db->prepare("UPDATE rooms SET name = ?, capacity = ?, `condition` = ? WHERE id = ?");
        $stmt->bind_param("sisi", $name, $capacity, $condition, $id);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];

        $stmt = $db->prepare("DELETE FROM rooms WHERE id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->close();
    }
}

$result = $db->query("SELECT * FROM rooms");
$rooms = $result->fetch_all(MYSQLI_ASSOC);
$result->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kelola Ruangan</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    <link rel="stylesheet" type="text/css" href="../css/manage_admin.css">
</head>
<body>
    <div class="header">
        <h1>Kelola Ruangan</h1>
        <a href="admin_dashboard.php" class="btn">Back to Dashboard</a>
    </div>
    <div class="container">
        <h2>Create Room</h2>
        <form method="POST" action="">
            <input type="text" name="id" placeholder="ID" required>
            <input type="text" name="name" placeholder="Room Name" required>
            <input type="number" name="capacity" placeholder="Capacity" min="7" max="20" required>
            <textarea name="condition" placeholder="Condition" required></textarea>
            <input type="submit" name="create" value="Create" class="btn">
        </form>
        <h2>Existing Rooms</h2>
        <table class="table">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Capacity</th>
                <th>Condition</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($rooms as $room) { ?>
            <tr>
                <form method="POST" action="">
                    <td>
                        <input type="text" name="id" value="<?php echo $room['id']; ?>" required>
                    </td>
                    <td>
                        <input type="text" name="name" value="<?php echo $room['name']; ?>" required>
                    </td>
                    <td>
                        <input type="number" name="capacity" value="<?php echo $room['capacity']; ?>" min="7" max="20" required>
                    </td>
                    <td>
                        <textarea name="condition" required><?php echo $room['condition']; ?></textarea>
                    </td>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $room['id']; ?>">
                        <input type="submit" name="update" value="Update" class="btn">
                        <input type="submit" name="delete" value="Delete" class="btn">
                    </td>
                </form>
            </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
