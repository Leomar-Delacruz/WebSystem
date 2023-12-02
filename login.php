<?php
require_once "database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enteredUsername = $_POST['username'];
    $enteredPassword = $_POST['password'];

    // Replace 'your_primary_key_column' and 'your_password_column' with the actual column names
    $stmt = $conn->prepare('SELECT your_primary_key_column, your_password_column FROM users WHERE UserName = ?');
    $stmt->bind_param('s', $enteredUsername);
    $stmt->execute();
    
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User found
        $user = $result->fetch_assoc();

        if ($enteredPassword === $user['UserID']) {
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
}
?>
