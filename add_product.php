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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
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
    </style>
</head>
<body>
    <h2>Add New Product</h2>

    <!-- Form for adding products -->
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="productName">Product Name:</label>
        <input type="text" id="productName" name="productName" required>

        <label for="pricePerUnit">Price Per Unit:</label>
        <input type="number" id="pricePerUnit" name="pricePerUnit" step="0.01" required>

        <button type="submit">Add Product</button>
    </form>
</body>
</html>