<?php
require_once "database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $supplierName = $_POST['supplierName'];
    $contactNumber = $_POST['contactNumber'];
    $email = $_POST['email'];
    $address = $_POST['address'];

    $sql = "INSERT INTO suppliers (SupplierName, ContactNumber, Email, Address) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die('Error preparing statement: ' . $conn->error);
    }

    $stmt->bind_param('ssss', $supplierName, $contactNumber, $email, $address);
    $stmt->execute();

    echo "Supplier added successfully.";

    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Supplier</title>
</head>
<body>
    <h2>Add Supplier</h2>
    <form action="supplier.php" method="post">
        <label for="supplierName">Supplier Name:</label>
        <input type="text" name="supplierName" required>

        <label for="contactNumber">Contact Number:</label>
        <input type="text" name="contactNumber" required>

        <label for="email">Email:</label>
        <input type="email" name="email" required>

        <label for="address">Address:</label>
        <input type="text" name="address" required></textarea>

        <input type="submit" value="Add Supplier">
    </form>

    <a href="supplierlist.php">Back</a>

</body>
</html>
