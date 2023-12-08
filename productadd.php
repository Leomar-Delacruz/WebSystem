

<?php
require_once "database.php";

// Check if the product ID is provided in the URL
if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Retrieve product information based on the provided ID
    $sqlSelect = "SELECT * FROM products WHERE ProductName = ?";
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
        // Retrieve form data
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
    <meta name="viewport" content="width=device-width, 
    initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link rel="stylesheet" href="/CSS/Product.css">
    <link rel="stylesheet" href="/CSS/button-1.css">
    <link rel="stylesheet" href="/CSS/button-2.css">
    <title>Add Product</title>
</head>
<body>

    
  <section class="parent-form">

    <button class="button2" id="Back">
        Back
    </button> 

    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $productId; ?>">

        <h2 class="display-6">Add Product</h2>
        <!-- New -->
        <input type="text" name="productName" class="input" placeholder="Product Name" required>

        <input type="number" id="pricePerUnit" class="input" name="pricePerUnit" step="0.01" value="<?php echo $product['PricePerUnit']; ?>" placeholder="Price per unit" required>

        <button type="submit" class="btn">Update Product</button>

        <!-- new -->
        
        <!-- <input type="text" name="category" class="input" placeholder="Category" required>

        <textarea name="description" rows="4" class="input" placeholder="Description" required></textarea>

        <input type="number" name="stockQuantity" class="input" placeholder="Stock Quantity" required>

        <input type="number" step="0.01" name="pricePerUnit" class="input" placeholder="Price per unit" required>

        <input type="number" name="supplierID" class="input" placeholder="Supplier Id" required>

        <input type="submit" value="Add Product" class="btn"> -->

    </form>

</section>





<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

<script>
    // This is Btn back
    var Back = document.getElementById("Back");

    Back.addEventListener("click", function() {
        // Go back to the previous page
        window.history.back();
    });
</script>

</html>
