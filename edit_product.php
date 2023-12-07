<?php
require_once "database.php";

// Check if the product ID is provided in the URL
if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Retrieve product information based on the provided ID
    $sqlSelect = "SELECT * FROM products WHERE ProductID = ?";
    $stmtSelect = $conn->prepare($sqlSelect);

    if (!$stmtSelect) {
        die('Error preparing statement: ' . $conn->error);
    }

    $stmtSelect->bind_param('i', $productId);
    $stmtSelect->execute();

    $resultSelect = $stmtSelect->get_result();

    if ($resultSelect->num_rows > 0) {
        $product = $resultSelect->fetch_assoc();
    } else {
        echo "Product not found.";
        exit();
    }

    $stmtSelect->close();

    // Check if the form is submitted for updating product information
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve form data
        $productName = $_POST['productName'];
        $pricePerUnit = $_POST['pricePerUnit'];

        // Prepare and execute the SQL statement to update product information
        $sqlUpdate = "UPDATE products SET ProductName = ?, PricePerUnit = ? WHERE ProductID = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);

        if (!$stmtUpdate) {
            die('Error preparing statement: ' . $conn->error);
        }

        $stmtUpdate->bind_param('sdi', $productName, $pricePerUnit, $productId);
        $stmtUpdate->execute();

        echo "Product updated successfully.";

        $stmtUpdate->close();
    }
} else {
    echo "Product ID not provided.";
    exit();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        h2 {
            color: #333;
        }

        form {
            width: 50%;
            margin: 20px auto;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        button {
            background-color: #008CBA;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .back-btn {
            background-color: #333;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h2>Edit Product</h2>

    <!-- Form for editing product -->
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $productId; ?>">
        <label for="productName">Product Name:</label>
        <input type="text" id="productName" name="productName" value="<?php echo $product['ProductName']; ?>" required>

        <label for="pricePerUnit">Price Per Unit:</label>
        <input type="number" id="pricePerUnit" name="pricePerUnit" step="0.01" value="<?php echo $product['PricePerUnit']; ?>" required>

        <button type="submit">Update Product</button>
    </form>

    <!-- Back button to product.php -->
    <a href="product.php" class="back-btn">Back to Product List</a>
</body>
</html>
