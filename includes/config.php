<?php
$server = "localhost";
$user = "root";
$password = "";
$dbname = "ruangku_db";

$db = mysqli_connect($server, $user, $password, $dbname);
if(!$db){
    die("Gagal terhubung dengan database: " . mysqli_connect_error());
}
?>
