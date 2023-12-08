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

// Search functionality
$searchKeyword = '';
if (isset($_GET['search'])) {
    $searchKeyword = $_GET['search'];
    $sqlSelect = "SELECT * FROM products WHERE ProductName LIKE '%$searchKeyword%'";
} else {
    $sqlSelect = "SELECT * FROM products";
}

$result = $conn->query($sqlSelect);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Information</title>
    <style>

        * {
            margin: 0;
            padding: 0;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .nav {
            background-color: #fff;
            box-shadow: 2px 2px 4px rgb(130, 129, 129);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 9vh;
        }

        .nav h2 {
            color: #000; 
            font-size: 2rem;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;

        }

        table, th, td {
            border: 1px solid #ddd;

        }

        th, td {
            padding: 12px;
            text-align: center;

        
        }

        th {
            background-color: #00BFA6;
            color: #fff;
             
        }


        .add-product-btn {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 5vh;
            width: 150px;
            margin: 20px auto;
            padding: 10px;
            text-align: center;
            background-color: #008CBA;
            color: #fff;
            text-decoration: none;
            border-radius: 20px;
        }


        .edit-link {
            display: inline-block;
            padding: 8px;
            background-color: #00BFA6; 
            color: white;
            font-weight: bold;
            text-decoration: none;
            border-radius: 3px;
        }

        .search-form {
            margin-top: 4vh;
            margin-left: 40vw;
            text-align: center;
        }

        .search-input {
            height: 5vh;
            width: 15vw;
            box-sizing: border-box;
        }

        .search-button {
            background-color: #008CBA;
            color: #fff;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }


        table {
            width: 60vw;
            height: 20vh;

            box-shadow: 2px 2px 4px rgb(130, 129, 129);
        }

        
    </style>
</head>
<body>

    <div class="nav">
        <h2>Product List</h2>
    </div>
    <!-- Search Form -->
    <form class="search-form" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="text" class="search-input" name="search" placeholder="Search by Product Name" value="<?php echo $searchKeyword; ?>">
        <button type="submit" class="search-button">Search</button>
    </form>

    <!-- Display the table of products -->
    <table>
  <div class="table-container">
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
 </div>
</table>
<a href="add_product.php" class="add-product-btn">Add Product</a>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
