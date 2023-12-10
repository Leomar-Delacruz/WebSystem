<?php

session_start();
require_once('database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare('SELECT * FROM users WHERE username = ? AND password = ?');
    $stmt->bind_param('ss', $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        // Assuming you retrieve full name from the database query
        $_SESSION['usersign'] = $user['usersign'];


        // Redirect based on the user's role
        if ($user['role'] === 'admin') {
            header('Location: /Assets/Admin_Dashboard/Dashboard.html');
        } else {
            header('Location: /Assets/Staff_Dashboard/Dashboard.html');
        }
        exit;
    } else {
        echo "Invalid username or password";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="/Assets/Login/login.css">
      <!-- This is Bootstrap CDN -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
      <link rel="icon" type="img/x-icon" href="#">
      <title>Login</title>
  </head>
<body>

  <section class="form-parent">

  <form id="loginForm" method="post" class="form" onsubmit="login()">

      <p class="heading display-4 ">Login</p>
      <input class="input display-7" type="text" id="username" name="username" placeholder="Username" required>
      <input class="input display-7" type="password" id="password" name="password" placeholder="Password" required>
      <!-- <a href="#" class="a-forgot lead text-primary">Forgot password?</a> -->
      <!-- <button type="button" class="btn text-white" onclick="login()">Login </button> -->
      <input type="submit" value="Signin" class="btn text-white">

  </form>

 </section>

 <div id="loginFailureMessage" class="login-failure-message">
 </div>



<!-- This is CDN Bootstrap -->
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>