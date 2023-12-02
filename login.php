<?php
require_once "database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enteredUsername = $_POST['username'];
    $enteredPassword = $_POST['password'];

    // Replace 'UserID' and 'Password' with the actual column names
    $stmt = $conn->prepare('SELECT UserID, Password FROM users WHERE UserName = ?');
    
    if (!$stmt) {
        die('Error preparing statement: ' . $conn->error);
    }

    $stmt->bind_param('s', $enteredUsername);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User found
        $user = $result->fetch_assoc();

        if ($enteredPassword === $user['Password']) {
            // Login successful
            $_SESSION['user_id'] = $user['UserID'];
            header('Location: dashboard.html'); // Redirect to the dashboard or another page
            exit();
        } else {
            // Password incorrect
            echo 'Invalid username or password.';
        }
    } else {
        // User not found
        echo 'Invalid username or password.';
    }

    $stmt->close();  // Close the statement after use
}
?>
