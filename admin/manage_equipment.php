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
        $description = $_POST['description'];

        $stmt = $db->prepare("INSERT INTO equipment (id, name, description) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $id, $name, $description);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['update'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];

        $stmt = $db->prepare("UPDATE equipment SET name = ?, description = ? WHERE id = ?");
        $stmt->bind_param("sss", $name, $description, $id);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];

        $stmt = $db->prepare("DELETE FROM equipment WHERE id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $stmt->close();
    }
}

$result = $db->query("SELECT * FROM equipment");
$equipment = $result->fetch_all(MYSQLI_ASSOC);
$result->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kelola Alat-alat</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
    <link rel="stylesheet" type="text/css" href="../css/manage_admin.css">
</head>
<body>
    <div class="header">
        <h1>Kelola Alat-alat</h1>
        <a href="admin_dashboard.php" class="btn">Back to Dashboard</a>
    </div>
    <div class="container">
        <h2>Create Equipment</h2>
        <form method="POST" action="">
            <input type="text" name="id" placeholder="ID" required>
            <input type="text" name="name" placeholder="Equipment Name" required>
            <textarea name="description" placeholder="Description" required></textarea>
            <input type="submit" name="create" value="Create" class="btn">
        </form>
        <h2>Existing Equipment</h2>
        <table class="table">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($equipment as $equip) { ?>
            <tr>
                <form method="POST" action="">
                    <td>
                        <input type="text" name="id" value="<?php echo $equip['id']; ?>" required>
                    </td>
                    <td>
                        <input type="text" name="name" value="<?php echo $equip['name']; ?>" required>
                    </td>
                    <td>
                        <textarea name="description" required><?php echo $equip['description']; ?></textarea>
                    </td>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $equip['id']; ?>">
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
