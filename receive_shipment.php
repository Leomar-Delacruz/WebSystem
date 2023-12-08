<?php
// database.php should contain your database connection logic
require_once "database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = $_POST['productName'];
    $quantity = $_POST['quantity'];

    // Assume 'products' is your products table
    $sql = "INSERT INTO products (ProductName, Quantity) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die('Error preparing statement: ' . $conn->error);
    }

    $stmt->bind_param('si', $productName, $quantity);
    $stmt->execute();

    echo "Shipment received successfully.";

    $stmt->close();
}

$conn->close();
?>
