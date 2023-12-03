<?php
require_once "database.php";

// Fetch data from the database
$sql = "SELECT transactionid, productname, transactiondate, quantity, price, totalamount FROM transaction";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Information</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Transaction Information</h2>
    <table>
        <thead>
            <tr>
                <th>TransactionID</th>
                <th>ProductName</th>
                <th>TransactionDate</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>TotalAmount</th>
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
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No transactions found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
