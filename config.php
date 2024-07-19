<?php
$servername = "37.27.108.55";
$username = "cdmpejek_tuzshop";
$password = "729288@TuzShop$";
$dbname = "cdmpejek_tuzshop";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
