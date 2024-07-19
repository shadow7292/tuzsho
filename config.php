<?php
$servername = "142.171.153.18";
$username = "a7669371_tuzshop";
$password = "729288@TuzShop$";
$dbname = "a7669371_tuzshop";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
