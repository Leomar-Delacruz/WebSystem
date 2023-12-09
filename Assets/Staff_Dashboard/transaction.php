<?php
require_once "database.php";

// Insert new transaction if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if all required fields are set
    if (
        isset($_POST['productname']) &&
        isset($_POST['transactiondate']) &&
        isset($_POST['quantity']) &&
        isset($_POST['price'])
    ) {
        // Retrieve form data
        $productName = $_POST['productname'];
        $transactionDate = $_POST['transactiondate'];
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

// Collect total amount if the "Collect Total Amount" button is clicked
if (isset($_POST['collect_total'])) {
    // Define condition for collecting total amount for the current day
    $currentDate = date("Y-m-d");
    $condition = "DATE(transactiondate) = '$currentDate'";
    
    $sql = "SELECT SUM(totalamount) AS total FROM transaction WHERE $condition";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $totalAmount = $row['total'];

        // Save the total amount and current date to another system
        $saveSql = "INSERT INTO collectingtotalamount (totalamount, collectiondate) VALUES ($totalAmount, '$currentDate')";
        $conn->query($saveSql);

        // Reset auto-increment value for transactionid
        $resetSql = "ALTER TABLE transaction AUTO_INCREMENT = 1";
        $conn->query($resetSql);

        // Redirect to another system with the collected data
        header("Location: transaction.php");
        exit(); // Ensure that subsequent code is not executed after redirection
    } else {
        echo "No transactions found to collect for the current day.";
    }
}

// Fetch data from the database, considering a condition for new data
$sql = "SELECT transactionid, productname, transactiondate, quantity, price, totalamount FROM transaction
        WHERE transactiondate >= (SELECT MAX(transactiondate) FROM transaction)
        ORDER BY transactionid DESC"; // Order by transactionid in descending order

$result = $conn->query($sql);
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">


    <title>Transaction Information</title>
    <style>

        * {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 70vw;
            margin: 20px auto;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: center;
            color: #343a40;
        }

        th {
            background-color: #d8f3dc;
        }

        .container {
            margin-top: 8vh;

            width: 70vw;
            height: 8vh;

            /* outline: 1px solid black; */

            display: flex;
            justify-content: space-between;
            align-items: center;


        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
        }

        .insert-btn {
            background-color: #588157; 
        }

        .collect-btn {
            background-color: #588157; 
        }

        .view-collect-btn {
            background-color: #588157; 
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
            color: #6c757d;
        }
    </style>
</head>
<body>
    
        <nav>
        <button type="button" class="btn btn-success" id="Back">
        Back</button>
        <p class="display-6">Transaction Information</p>
        </nav>

    <div class="container">
        <a href="inserting.php" class="btn insert-btn">Insert New Transaction</a>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <button type="submit" class="btn collect-btn" name="collect_total" onclick="return confirm('Are you sure you want to collect the total amount?')">Collect Total Amount</button>
            <a href="viewtotalamount.php" class="btn view-collect-btn">View Collected Total</a>
        </form>
    </div>

    <table id="transactionTable">
        <thead>
            <tr>
                <th>TransactionID</th>
                <th>ProductName</th>
                <th>TransactionDate</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>TotalAmount</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Display data in the HTML table
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["transactionid"] . "</td>";
                    echo "<td>" . $row["productname"] . "</td>";
                    echo "<td>" . $row["transactiondate"] . "</td>";
                    echo "<td>" . $row["quantity"] . "</td>";
                    echo "<td>" . $row["price"] . "</td>";
                    echo "<td>" . $row["totalamount"] . "</td>";
                    echo "<td><a href='edittransaction.php?id=" . $row["transactionid"] . "' class='btn btn-success'>Edit</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='7'>No transactions found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <script>
        function deleteData() {
            if (confirm('Are you sure you want to delete all data?')) {
                // Remove table rows
                var table = document.getElementById("transactionTable");
                var rowCount = table.rows.length;
                for (var i = rowCount - 1; i > 0; i--) {
                    table.deleteRow(i);
                }
            }
        }
    </script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
<script>
      // This is Btn Back

  var Back = document.getElementById("Back");

  Back.addEventListener("click", function() {
    // Redirect to /Assets/Admin_Dashboard/Dashboard.html" directly
    window.location.href = "/Assets/Admin_Dashboard/Dashboard.html";
  });
  </script>
</html>
