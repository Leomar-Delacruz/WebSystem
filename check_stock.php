<?php
// database.php should contain your database connection logic
require_once "database.php";

// Assume 'products' is your products table
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Stock Levels</title>
</head>
<body>
    <h2>Stock Levels</h2>
    <table border="1">
        <tr>
            <th>Product Name</th>
            <th>Quantity</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['ProductName'] . "</td>";
                echo "<td>" . $row['Quantity'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='2'>No products found</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
