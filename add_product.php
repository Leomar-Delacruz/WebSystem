<?php
require_once "database.php";

// Check if the form is submitted
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

    $stmt->bind_param('sd', $productName, $pricePerUnit); // 's' for string, 'd' for double
    $stmt->execute();

    echo "Product added successfully.";

    $stmt->close();

    // Redirect back to product.php
    header("Location: product.php");
    exit();
}

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

    <!-- Form for adding products -->
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <h2 class="display-6">Add Product</h2>
        
        <label for="productName">Product Name:</label>
        <input type="text" id="productName" name="productName" required>

        <label for="pricePerUnit">Price Per Unit:</label>
        <input type="number" id="pricePerUnit" name="pricePerUnit" step="0.01" required>

        <button type="submit">Add Product</button>
    </form>


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
