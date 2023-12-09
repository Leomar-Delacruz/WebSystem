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
    <title>Add Supplier</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin: 10px 0;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #008CBA;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #008CBA;
            text-decoration: none;
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
    </style>
</head>
<body>

    <nav>
    <a href="transaction.php" class="btn btn-success btn-lg">Back</a>
    <p class="display-6">Add New Transaction</p>
    </nav>

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

        <input type="submit" value="Add Supplier">
        <a href="supplierlist.php">Back</a>
    </form>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
