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
        // Display a success message and redirect to the previous page
        echo "<script>
                alert('Transaction updated successfully!');
                window.location.href = 'transaction.php';
              </script>";
        exit();
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

        nav {
            display: flex;
            justify-content: space-around;
            align-items: center;
            width: 100vw;
            height: 10vh;

            box-shadow: 2px 5px 4px #ddd;
            
            /* outline: 1px solid black; */
        }

        nav p {
            margin-right: 28vw;
        }

        .container {
            margin-top: 8vh;
            /* outline: 1px solid black; */

            width: 40vw;
            height: 56vh;

            border-radius: 20px;
            box-shadow: 4px 5px 4px #ddd;
        }

        form {
            width: 40%;
            height: 60vh;
            margin: auto;
            /* outline: 1px solid black; */

            display: flex;
            flex-direction: column;
            flex-wrap: wrap;
            align-content: space-evenly;
            gap: 1vh;
        }

        input {
            width: 20vw;
            height: 6vh;
        }
    </style>
</head>
<body>
    
    <nav>
        <a href="transaction.php" class="btn btn-success btn-lg">Back</a>
        <p class="display-6">Edit Transaction</p>
    </nav>

    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'] . '?id=' . $transactionID); ?>" method="post">

            <div>   
            </div>
            <label for="product_name" class="lead
            ">Product Name:</label>
            <input type="text" name="product_name" value="<?php echo htmlspecialchars($productName); ?>" required>

            <label for="transaction_date" class="lead">Transaction Date:</label>
            <input type="date" name="transaction_date" value="<?php echo htmlspecialchars($transactionDate); ?>" required>

            <label for="quantity" class="lead">Quantity:</label>
            <input type="number" name="quantity" value="<?php echo htmlspecialchars($quantity); ?>" required>

            <label for="price" class="lead">Price:</label>
            <input type="number" name="price" step="0.01" value="<?php echo htmlspecialchars($price); ?>" required>

            <input type="submit" value="Update Transaction" class="btn btn-success">
        </form>
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>