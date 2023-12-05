<?php
require_once "database.php";

// Insert new transaction if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

$conn->close();
?>
