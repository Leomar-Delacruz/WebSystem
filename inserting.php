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
            // Close the database connection before outputting JavaScript
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
                <script>
                    // Show success alert
                    alert("New transaction added successfully!");
                    // Ask user to go back or stay on the page
                    if (confirm("Do you want to go back to Transactions?")) {
                        // If user clicks 'OK', redirect to transaction.php
                        window.location.href = 'transaction.php';
                    }
                </script>
            </body>
            </html>
            <?php
            exit; // Stop further execution of the PHP script
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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <title>Inserting</title>

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

        label {
            color: #6c757d;
        }

        nav p {
            color: #6c757d; 
        }
    </style>
</head>
<body>

    <nav>
        <a href="transaction.php" class="btn btn-success btn-lg">Back</a>
        <p class="display-6">Add New Transaction</p>
    </nav>

    <div class="container">
        <form action="inserting.php" method="post">

            <div></div>

            <label for="product_name" class="lead">Product Name:</label>
            <input type="text" name="product_name" required>

            <label for="transaction_date" class="lead">Transaction Date:</label>
            <input type="date" name="transaction_date" required>

            <label for="quantity" class="lead">Quantity:</label>
            <input type="number" name="quantity" required>

            <label for="price" class="lead">Price:</label>
            <input type="number" name="price" step="0.01" required>

            <input type="submit" value="Add Transaction" class="btn btn-success">
        </form>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>
