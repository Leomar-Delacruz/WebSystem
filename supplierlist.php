<?php
require_once "database.php";

// Fetch and display information about suppliers
$sqlSelect = "SELECT * FROM suppliers";
$result = $conn->query($sqlSelect);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Information</title>
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
            width: 80%;
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

        .add-supplier-btn {
            display: block;
            width: 150px;
            margin: 20px auto;
            padding: 10px;
            text-align: center;
            background-color: #008CBA;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
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
        <a href="transaction.php" class="btn btn-success btn-lg">Back</a>
        <p class="display-6">Supplier Information</p>
    </nav>

    <!-- Display the table of suppliers -->
    <table>
        <thead>
            <tr>
                <th>Supplier ID</th>
                <th>Supplier Name</th>
                <th>Contact Number</th>
                <th>Email</th>
                <th>Address</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['SupplierID'] . "</td>";
                    echo "<td>" . $row['SupplierName'] . "</td>";
                    echo "<td>" . $row['ContactNumber'] . "</td>";
                    echo "<td>" . $row['Email'] . "</td>";
                    echo "<td>" . $row['Address'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No suppliers found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Add Supplier Button -->
    <a href="supplier.php" class="add-supplier-btn">Add Supplier</a>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
