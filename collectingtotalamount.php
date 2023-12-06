<?php
require_once "database.php";

// Fetch collected total amounts and dates from another_system table
$sql = "SELECT totalamount, collectiondate FROM collectingtotalamount";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Collected Total Amounts</title>
    <style>
        /* Your styles go here */
    </style>
</head>
<body>
    <!-- Your HTML content goes here -->

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
