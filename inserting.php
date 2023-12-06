<?php
require_once "database.php";

// Insert new transaction if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if all required fields are set
    if (
        isset($_POST['product_name']) &&
        isset($_POST['transaction_date']) &&
        isset($_POST['quantity']) &&
        isset($_POST['price'])
    ) {
        // Retrieve form data
        $productName = $_POST['product_name'];
        $transactionDate = $_POST['transaction_date'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];

        // Perform validation and sanitation as needed

        // Calculate total amount
        $totalAmount = $quantity * $price;

        // Insert data into the Transactions table
        $insertSql = "INSERT INTO transaction (productname, transactiondate, quantity, price, totalamount)
                      VALUES ('$productName', '$transactionDate', $quantity, $price, $totalAmount)";

        if ($conn->query($insertSql) === TRUE) {
            echo "New transaction added successfully!";
            echo "<br><a href='transaction.php'>Go back to Transactions</a>";
        } else {
            echo "Error: " . $insertSql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserting</title>
</head>
<body>
    <form action="inserting.php" method="post">
        <h2>Add New Transaction</h2>
        <label for="product_name">Product Name:</label>
        <input type="text" name="product_name" required>

        <label for="transaction_date">Transaction Date:</label>
        <input type="date" name="transaction_date" required>

        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" required>

        <label for="price">Price:</label>
        <input type="number" name="price" step="0.01" required>

        <input type="submit" value="Add Transaction">
    </form>
</body>
</html>
