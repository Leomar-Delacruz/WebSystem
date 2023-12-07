<?php
require_once "database.php";

// Assuming your database connection is established in "database.php"

// Check if the request method is POST (form submission)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $productName = $_POST['productName'];
    $pricePerUnit = $_POST['pricePerUnit'];

    // Prepare and execute the SQL statement to insert data into the products table
    $sql = "INSERT INTO products (ProductName, PricePerUnit) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die('Error preparing statement: ' . $conn->error);
    }

    $stmt->bind_param('sssidi', $productName, $stockQuantity, $pricePerUnit);
    $stmt->execute();

    echo "Product added successfully.";

    $stmt->close();
}

// Fetch and display information about products
$sqlSelect = "SELECT * FROM products";
$result = $conn->query($sqlSelect);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Information</title>
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

        .add-product-btn {
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

        .edit-link {
            display: inline-block;
            padding: 8px;
            background-color:green; /* Light green color */
            color: white;
            font-weight: bold;;
            text-decoration: none;
            border-radius: 3px;
        }
    </style>
</head>
<body>
    <h2>Product List</h2>

    <!-- Display the table of products -->
    <table>
    <thead>
        <tr>
            <th>Product Name</th>
            <th>Price Per Unit</th>
            <th>Edit</th> <!-- Add a new column for the action -->
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['ProductName'] . "</td>";
                echo "<td>" . $row['PricePerUnit'] . "</td>";
                echo "<td><a class='edit-link' href='edit_product.php?id=" . $row['ProductID'] . "'>Edit</a></td>"; // Add Edit link
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No products found</td></tr>";
        }
        ?>
    </tbody>
</table>
<a href="product_information.php" class="add-product-btn">Add Product</a>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
