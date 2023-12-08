<?php
require_once "database.php";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $productName = $_POST['productName'];
    $pricePerUnit = $_POST['pricePerUnit'];

    // Prepare and execute the SQL statement to insert data into the products table
    $sql = "INSERT INTO products (ProductName, PricePerUnit) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die('Error preparing statement: ' . $conn->error);
    }

    $stmt->bind_param('sd', $productName, $pricePerUnit); // 's' for string, 'd' for double
    $stmt->execute();

    echo "Product added successfully.";

    $stmt->close();

    // Redirect back to product.php
    header("Location: product.php");
    exit();
}

$conn->close();
?>
