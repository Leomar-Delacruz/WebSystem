<?php
<<<<<<< HEAD
// Database connection
$hostname = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "ims_db";

$conn = mysqli_connect($hostname, $dbUser, $dbPassword, $dbName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
=======
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ims_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
>>>>>>> bfdf1a3868b4ce36771b7d4ac1abc2c0e842fd89
}
?>