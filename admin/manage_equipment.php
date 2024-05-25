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
        $description = $_POST['description'];
        $stmt = $conn->prepare("INSERT INTO equipment (name, description) VALUES (:name, :description)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->execute();
    } elseif (isset($_POST['update'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $stmt = $conn->prepare("UPDATE equipment SET name = :name, description = :description WHERE id = :id");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        $stmt = $conn->prepare("DELETE FROM equipment WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}

$equipment = $conn->query("SELECT * FROM equipment")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Equipment</title>
    <link rel="stylesheet" type="text/css" href="../css/admin_style.css">
</head>
<body>
    <div class="header">
        <h1>Manage Equipment</h1>
    </div>
    <div class="container">
        <h2>Create Equipment</h2>
        <form method="POST" action="">
            <input type="text" name="name" placeholder="Equipment Name" required>
            <textarea name="description" placeholder="Description" required></textarea>
            <input type="submit" name="create" value="Create" class="btn">
        </form>
        <h2>Existing Equipment</h2>
        <table class="table">
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($equipment as $item) { ?>
            <tr>
                <td><?php echo $item['name']; ?></td>
                <td><?php echo $item['description']; ?></td>
                <td>
                    <form method="POST" action="" style="display:inline-block;">
                        <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                        <input type="text" name="name" value="<?php echo $item['name']; ?>" required>
                        <textarea name="description" required><?php echo $item['description']; ?></textarea>
                        <input type="submit" name="update" value="Update" class="btn">
                    </form>
                    <form method="POST" action="" style="display:inline-block;">
                        <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
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
