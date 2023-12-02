<?php
require_once "database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customerName = $_POST['customerName'];
    $contactNumber = $_POST['contactNumber'];
    $email = $_POST['email'];

    $sql = "INSERT INTO Customers (CustomerName, ContactNumber, Email) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die('Error preparing statement: ' . $conn->error);
    }

    $stmt->bind_param('sss', $customerName, $contactNumber, $email);
    $stmt->execute();

    echo "Customer added successfully.";

    $stmt->close();
}

$conn->close();
?>
