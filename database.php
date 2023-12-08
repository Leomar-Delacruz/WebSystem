<?php
// Database connection
$hostname = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "ims_db";

$conn = mysqli_connect($hostname, $dbUser, $dbPassword, $dbName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>