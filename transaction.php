<?php
require_once "database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $transactionDate = $_POST['transactionDate'];
    $productID = $_POST['productID'];
    $quantity = $_POST['quantity'];
    $totalAmount = $_POST['totalAmount'];
    $userID = $_POST['userID'];

    $sql = "INSERT INTO transactions (TransactionDate, ProductID, Quantity, TotalAmount, UserID) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die('Error preparing statement: ' . $conn->error);
    }

    $stmt->bind_param('siiid', $transactionDate, $productID, $quantity, $totalAmount, $userID);
    $stmt->execute();

    echo "Transaction added successfully.";

    $stmt->close();
}

$conn->close();
?>
