<?php
include("includes/config.php");
include("includes/functions.php");

if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] == 'Admin') {
        header("Location: admin/admin_dashboard.php");
        exit();
    } elseif ($_SESSION['role'] == 'Operator') {
        header("Location: operator/operator_dashboard.php");
        exit();
    } elseif ($_SESSION['role'] == 'Manajer') {
        header("Location: manager/manager_dashboard.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ruangku</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script>
        function updateTime() {
            var today = new Date();
            var date = today.toLocaleDateString(undefined, { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
            var time = today.toLocaleTimeString();
            document.getElementById('datetime').innerHTML = date + ' ' + time;
        }
        setInterval(updateTime, 1000);
    </script>
    <style>
        .header {
            display: grid;
            grid-template-columns: auto 1fr auto;
            align-items: center;
        }
        .header h1 {
            justify-self: center;
        }
        .header .datetime {
            text-align: right;
            margin-right: 10px;
        }
        .header .btn {
            justify-self: end;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Ruangku</h1>
        <h3 class="datetime" id="datetime"></h3>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="logout.php" class="btn">Logout</a>
        <?php else: ?>
            <a href="login.php" class="btn">Login</a>
        <?php endif; ?>
    </div>
    <div class="container">
        <h2>Welcome to Ruangku</h2>
        <p>UMKM "Ruangku" offers a variety of meeting rooms for public rental. Each room varies in capacity (between 7 to 20 seats) and is equipped with meeting tools such as computers, projectors, and more. Our mission is to provide flexible and affordable meeting spaces for businesses and individuals. Whether you need a space for a team meeting, a client presentation, or a workshop, Ruangku has the perfect room for you</p>
        <h2>Rental Terms and Conditions</h2>
        <ol>
            <li>Rentals are subject to availability. We recommend booking in advance to ensure availability of your preferred meeting room.</li>
            <li>Minimum rental duration is 2 hours.</li>
            <li>Rental rates vary depending on the size of the meeting room and additional equipment rented.</li>
            <li>Customers are required to pay in advance at the time of booking.</li>
            <li>Cancellations must be made at least 24 hours prior to the scheduled rental time to receive a full refund.</li>
            <li>Customers are responsible for any damages to the rented space or equipment during their rental period.</li>
            <li>Ruangku reserves the right to refuse service to anyone.</li>
        </ol>
    </div>
    <div class="footer">
        <p>Contact us: Jl. Veteran No. 1, Purwakarta, Indonesia | Phone: +62 123 321 549 | e-mail: ruangku@mail.com</p>
        <p>&copy; 2024 Ruangku. All rights reserved.</p>
    </div>
</body>
</html>
