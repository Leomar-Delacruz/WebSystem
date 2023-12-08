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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    
    <title>Edit Transaction</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            font-family: Arial, sans-serif;
        }

        header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
            width: 100%;
        }

        nav {
            display: flex;
            justify-content: space-around;
            background-color: #f1f1f1;
            padding: 10px;
            width: 100%;
        }

        nav a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }

        form {
            width: 50%;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <header>
        <h2>Edit Transaction</h2>
    </header>
    
    <nav>
        <a href="#">Home</a>
        <a href="#">About</a>
        <a href="#">Contact</a>
    </nav>

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
    
    <a href="transaction.php">Back to Transactions</a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>