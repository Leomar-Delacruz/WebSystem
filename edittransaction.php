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
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Your Company</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="transaction.php">Transactions</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="col-md-6">
            <h2 class="mt-3">Edit Transaction</h2>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . '?id=' . $transactionID); ?>" method="post">
                <label for="product_name" class="form-label">Product Name:</label>
                <input type="text" name="product_name" value="<?php echo htmlspecialchars($productName); ?>" class="form-control" required>

                <label for="transaction_date" class="form-label">Transaction Date:</label>
                <input type="date" name="transaction_date" value="<?php echo htmlspecialchars($transactionDate); ?>" class="form-control" required>

                <label for="quantity" class="form-label">Quantity:</label>
                <input type="number" name="quantity" value="<?php echo htmlspecialchars($quantity); ?>" class="form-control" required>

                <label for="price" class="form-label">Price:</label>
                <input type="number" name="price" step="0.01" value="<?php echo htmlspecialchars($price); ?>" class="form-control" required>

                <button type="submit" class="btn btn-primary mt-3">Update Transaction</button>
            </form>
            <a href="transaction.php" class="btn btn-secondary mt-3">Back to Transactions</a>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

