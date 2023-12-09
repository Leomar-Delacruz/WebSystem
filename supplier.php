<?php
require_once "database.php";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $supplierName = $_POST['supplierName'];
    $contactNumber = $_POST['contactNumber'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    // Prepare and execute the SQL statement to insert data into the suppliers table
    $sql = "INSERT INTO suppliers (SupplierName, ContactNumber, Email, Address) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die('Error preparing statement: ' . $conn->error);
    }

    $stmt->bind_param('ssss', $supplierName, $contactNumber, $email, $address);
    $stmt->execute();

    // Display JavaScript alert after successful insertion
    echo '<script>alert("Supplier added successfully.");</script>';

    $stmt->close();
}

// Fetch and display information about suppliers
$sqlSelect = "SELECT * FROM suppliers";
$result = $conn->query($sqlSelect);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <title>Add Supplier</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            font-family: Arial, sans-serif;
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
        }

        .container {
            margin-top: 8vh;
            /* outline: 1px solid black; */

            width: 40vw;
            height: 56vh;

            border-radius: 20px;
            box-shadow: 4px 5px 4px #ddd;
        }

        form {
            width: 40%;
            height: 60vh;
            margin: auto;
            /* outline: 1px solid black; */

            display: flex;
            flex-direction: column;
            flex-wrap: wrap;
            align-content: space-evenly;
            gap: 1vh;
        }

        input {
            width: 20vw;
            height: 6vh;
        }

        label, input {
            color: #6c757d;
        }

        nav p {
            color: #6c757d; 
        }
    </style>
</head>
<body>

    <nav>
    <a href="transaction.php" class="btn btn-success btn-lg">Back</a>
    <p class="display-6">Add Supplier</p>
    </nav>

    <div class="container">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <h2>Add Supplier</h2>

        <label for="supplierName">Supplier Name:</label>
        <input type="text" name="supplierName" required>

        <label for="contactNumber">Contact Number:</label>
        <input type="text" name="contactNumber" required>

        <label for="email">Email:</label>
        <input type="email" name="email" required>

        <label for="address">Address:</label>
        <input type="text" name="address" required>

        <input type="submit" value="Add Supplier" class="btn btn-success">
    </form>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
