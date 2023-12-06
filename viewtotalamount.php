<?php
require_once "database.php";

// Fetch collected total amounts and dates from another_system table
$sql = "SELECT totalamount, collectiondate FROM collectingtotalamount";
$result = $conn->query($sql);

// Check for query execution success
if ($result === false) {
    die("Error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Collected Total Amounts</title>
    <style>
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
            width: 50%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .container {
            text-align: center;
            margin-top: 20px;
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

        .back-btn {
            background-color: #333; /* Dark Gray */
        }
    </style>
</head>
<body>
    <h2>View Collected Total Amounts</h2>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Total Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Display data in the HTML table
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["collectiondate"] . "</td>";
                    echo "<td>" . $row["totalamount"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='2'>No collected total amounts found</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <div class="container">
        <a href="transaction.php" class="btn back-btn">Back to Transactions</a>
    </div>
</body>
</html>
