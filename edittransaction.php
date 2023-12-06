<?php
require_once "database.php";

// Check if ID parameter is set
if(isset($_GET['id'])) {
    $transactionID = $_GET['id'];

    // Retrieve transaction details from the database
    $sql = "SELECT * FROM transaction WHERE transactionid = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $transactionID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $productName = $row["productname"];
        $transactionDate = $row["transactiondate"];
        $quantity = $row["quantity"];
        $price = $row["price"];
        $totalAmount = $row["totalamount"];
    } else {
        echo "Transaction not found.";
        exit();
    }
} else {
    echo "Transaction ID not provided.";
    exit();
}

// Update transaction if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = $_POST['product_name'];
    $transactionDate = $_POST['transaction_date'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    // Perform validation and sanitation as needed

    // Calculate total amount
    $totalAmount = $quantity * $price;

    // Update data in the transaction table
    $updateSql = "UPDATE transaction 
                  SET productname = ?, transactiondate = ?, 
                  quantity = ?, price = ?, totalamount = ?
                  WHERE transactionid = ?";

    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param('ssiddi', $productName, $transactionDate, $quantity, $price, $totalAmount, $transactionID);

    if ($stmt->execute()) {
        echo "Transaction updated successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Transaction</title>
</head>
<body>
    <h2>Edit Transaction</h2>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . '?id=' . $transactionID); ?>" method="post">
        <label for="product_name">Product Name:</label>
        <input type="text" name="product_name" value="<?php echo htmlspecialchars($productName); ?>" required>

        <label for="transaction_date">Transaction Date:</label>
        <input type="date" name="transaction_date" value="<?php echo htmlspecialchars($transactionDate); ?>" required>

        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" value="<?php echo htmlspecialchars($quantity); ?>" required>

        <label for="price">Price:</label>
        <input type="number" name="price" step="0.01" value="<?php echo htmlspecialchars($price); ?>" required>

        <input type="submit" value="Update Transaction">
    </form>
</body>
</html>
