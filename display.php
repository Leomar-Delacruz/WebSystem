<?php
require_once "database.php";
try {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($_POST['action'] === 'addSupplier') {
            addSupplier($pdo, $_POST['supplierName'], $_POST['contactPerson'], $_POST['contactNumber'], $_POST['email']);
        } elseif ($_POST['action'] === 'addProduct') {
            addProduct($pdo, $_POST['productName'], $_POST['category'], $_POST['description'], $_POST['stockQuantity'], $_POST['pricePerUnit'], $_POST['supplierID']);
        }
    }

    function addSupplier($pdo, $name, $contactPerson, $contactNumber, $email)
    {
        $stmt = $pdo->prepare('INSERT INTO Suppliers (SupplierName, ContactPerson, ContactNumber, Email) VALUES (?, ?, ?, ?)');
        $stmt->execute([$name, $contactPerson, $contactNumber, $email]);
    }

    function addProduct($pdo, $name, $category, $description, $stockQuantity, $pricePerUnit, $supplierID)
    {
        $stmt = $pdo->prepare('INSERT INTO Products (ProductName, Category, Description, StockQuantity, PricePerUnit, SupplierID) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([$name, $category, $description, $stockQuantity, $pricePerUnit, $supplierID]);
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
header('Location: main.html');
?>
