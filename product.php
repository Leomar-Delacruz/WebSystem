<?php
require_once "database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = $_POST['productName'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $stockQuantity = $_POST['stockQuantity'];
    $pricePerUnit = $_POST['pricePerUnit'];
    $supplierID = $_POST['supplierID'];

    $sql = "INSERT INTO products (ProductName, Category, Description, StockQuantity, PricePerUnit, SupplierID) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die('Error preparing statement: ' . $conn->error);
    }

    $stmt->bind_param('sssidi', $productName, $category, $description, $stockQuantity, $pricePerUnit, $supplierID);
    $stmt->execute();

    echo "Product added successfully.";

    $stmt->close();
}

$conn->close();
?>
