<?php
include("../includes/config.php");
include("../includes/functions.php");

redirectIfNotLoggedIn();
if (!isOperator()) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_name = $_POST['customer_name'];
    $customer_phone = $_POST['customer_phone'];
    $room_id = $_POST['room_id'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    $insert_customer_query = "INSERT INTO customers (name, phone) VALUES ('$customer_name', '$customer_phone')";
    if(mysqli_query($db, $insert_customer_query)) {
        $customer_id = mysqli_insert_id($db);

        // Loop through the equipment_ids array and insert each equipment separately
        foreach($_POST['equipment_id'] as $equipment_id) {
            $insert_rental_query = "INSERT INTO rentals (customer_id, room_id, equipment_id, start_time, end_time) VALUES ('$customer_id', '$room_id', '$equipment_id', '$start_time', '$end_time')";
            if(mysqli_query($db, $insert_rental_query)) {
                continue; // If insertion successful, continue to next iteration
            } else {
                echo "Error: " . $insert_rental_query . "<br>" . mysqli_error($db);
                break; // If insertion fails, break the loop
            }
        }

        // If all insertions successful, redirect to operator_dashboard
        header("Location: operator_dashboard.php");
        exit();
    } else {
        echo "Error: " . $insert_customer_query . "<br>" . mysqli_error($db);
    }
}

$rooms_query = "SELECT * FROM rooms";
$rooms_result = mysqli_query($db, $rooms_query);
$rooms = mysqli_fetch_all($rooms_result, MYSQLI_ASSOC);

$equipment_query = "SELECT * FROM equipment";
$equipment_result = mysqli_query($db, $equipment_query);
$equipment = mysqli_fetch_all($equipment_result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Process Rental</title>
    <link rel="stylesheet" type="text/css" href="../css/op_style.css">
</head>
<body>
    <div class="header">
        <h1>Process Rental</h1>
    </div>
    <div class="container">
        <form method="POST" action="">
            <h2>Customer Information</h2>
            <input type="text" name="customer_name" placeholder="Customer Name" required>
            <input type="text" name="customer_phone" placeholder="Customer Phone" required>

            <h2>Rental Information</h2>
            <label for="room_id">Select Room:</label>
            <select name="room_id" required>
                <?php foreach ($rooms as $room): ?>
                <option value="<?php echo $room['id']; ?>"><?php echo $room['name']; ?> (Capacity: <?php echo $room['capacity']; ?>)</option>
                <?php endforeach; ?>
            </select>

            <label for="equipment_id">Select Equipment:</label>
            <div id="equipment_list">
                <!-- Initially, only one equipment option is shown -->
                <select name="equipment_id[]" required>
                    <option value="">None</option>
                    <?php foreach ($equipment as $item): ?>
                    <option value="<?php echo $item['id']; ?>"><?php echo $item['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="button" onclick="addEquipment()">Add Equipment</button>

            <input type="datetime-local" name="start_time" required>
            <input type="datetime-local" name="end_time" required>
            
            <input type="submit" value="Process Rental">
        </form>
        <a href="operator_dashboard.php">Back to Dashboard</a>
    </div>

    <script>
        function addEquipment() {
            var equipmentList = document.getElementById("equipment_list");
            var newEquipmentSelect = document.createElement("select");
            newEquipmentSelect.setAttribute("name", "equipment_id[]");
            newEquipmentSelect.required = true;
            var noneOption = document.createElement("option");
            noneOption.value = "";
            noneOption.text = "None";
            newEquipmentSelect.appendChild(noneOption);
            <?php foreach ($equipment as $item): ?>
            var option = document.createElement("option");
            option.value = "<?php echo $item['id']; ?>";
            option.text = "<?php echo $item['name']; ?>";
            newEquipmentSelect.appendChild(option);
            <?php endforeach; ?>

            var deleteButton = document.createElement("button");
            deleteButton.innerHTML = "Delete";
            deleteButton.type = "button";
            deleteButton.onclick = function() {
                equipmentList.removeChild(newEquipmentSelect);
                equipmentList.removeChild(deleteButton);
            };
            
            equipmentList.appendChild(newEquipmentSelect);
            equipmentList.appendChild(deleteButton);
        }
    </script>
</body>
</html>
