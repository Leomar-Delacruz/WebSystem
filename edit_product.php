<?php
require_once "database.php";

// Check if the product ID is provided in the URL
if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Retrieve product information based on the provided ID
    $sqlSelect = "SELECT * FROM products WHERE ProductID = ?";
    $stmtSelect = $conn->prepare($sqlSelect);

    if (!$stmtSelect) {
        die('Error preparing statement: ' . $conn->error);
    }

    $stmtSelect->bind_param('i', $productId);
    $stmtSelect->execute();

    $resultSelect = $stmtSelect->get_result();

    if ($resultSelect->num_rows > 0) {
        $product = $resultSelect->fetch_assoc();
    } else {
        echo "Product not found.";
        exit();
    }

    $stmtSelect->close();

    // Check if the form is submitted for updating product information
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Check if the "Delete" button is clicked
        if (isset($_POST['delete'])) {
            // Prepare and execute the SQL statement to delete the product
            $sqlDelete = "DELETE FROM products WHERE ProductID = ?";
            $stmtDelete = $conn->prepare($sqlDelete);

            if (!$stmtDelete) {
                die('Error preparing statement: ' . $conn->error);
            }

            $stmtDelete->bind_param('i', $productId);
            $stmtDelete->execute();

            echo "Product deleted successfully.";

            $stmtDelete->close();

            // Redirect to the product list after deletion
            header("Location: product.php");
            exit();
        }

        // If not deleting, then it's an update
        $productName = $_POST['productName'];
        $pricePerUnit = $_POST['pricePerUnit'];

        // Prepare and execute the SQL statement to update product information
        $sqlUpdate = "UPDATE products SET ProductName = ?, PricePerUnit = ? WHERE ProductID = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);

        if (!$stmtUpdate) {
            die('Error preparing statement: ' . $conn->error);
        }

        $stmtUpdate->bind_param('sdi', $productName, $pricePerUnit, $productId);
        $stmtUpdate->execute();

        echo "Product updated successfully.";

        $stmtUpdate->close();
    }
} else {
    echo "Product ID not provided.";
    exit();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <title>Edit Product</title>
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
            text-align: center;
        }

        .navbar {
            background-color: #fff;
            color: rgb(62, 62, 62);
            box-shadow: 2px 3px 5px  rgb(130, 129, 129);
            text-align: center;
            width: 100vw;
            height: 10vh;
            display: flex;
            justify-content: center;
            align-items: center;
            
        }

        .navbar a {
            color: rgb(83, 83, 83);
            text-decoration: none;
            margin: 0 15px;
            font-size: 2rem;
        }

        h2 {
            color: rgb(103, 102, 102);
            font-size: 2rem;
            margin-top: 5vh;
        }

        form {
            width: 30vw;
            height: 55vh;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1vh;
            border-radius: 20px;
            box-shadow: 2px 2px 5px  rgb(130, 129, 129);

        }

        label {
            margin-top: 4vh;
            margin-right: 15vw;
            color: rgb(103, 102, 102);
        
        }

        input {
            width: 20vw;
            height: 7vh;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            font-size: 1.2rem;
            color: rgb(103, 102, 102);
        }

        button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 10px;

            width: 10vw;
            height: 7vh;
        }


        .back-btn {
            text-decoration: none;
            padding: 20px 20px;
            border-radius: 20px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="product.php">Product List</a>
    </div>

    <h2>Edit Product</h2>

    <!-- Form for editing product -->
    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $productId; ?>">
        <label for="productName">Product Name:</label>
        <input type="text" id="productName" name="productName" value="<?php echo $product['ProductName']; ?>" required>

        <label for="pricePerUnit">Price Per Unit:</label>
        <input type="number" id="pricePerUnit" name="pricePerUnit" step="0.01" value="<?php echo $product['PricePerUnit']; ?>" required>

        <button type="submit" class="btn btn-outline-primary">Update Product</button>
        
        <!-- Delete Product Button -->
        <button type="submit" class="delete-btn btn btn-outline-danger" name="delete">Delete Product</button>
        
    </form>

    <!-- Back button to product.php -->
    <a href="product.php" class="back-btn btn btn-outline-success">Back to Product List</a>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>

