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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receive Shipment</title>
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
    <h2>Receive Shipment</h2>
    
    <!-- Form for receiving a new shipment -->
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="productName">Product Name:</label>
        <input type="text" id="productName" name="productName" required>

        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" required>

        <button type="submit">Receive Shipment</button>
    </form>
</body>
</html>
