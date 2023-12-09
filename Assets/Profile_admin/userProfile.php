<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ims_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['username'])) {
  header('Location: userProfile.php');
  exit;
}

if ($_SESSION['role'] !== 'admin') {
  // Redirect if the user is not an admin
  header('Location: /UserProfile Security/userProfileStaff.php');
  exit;
}

// Retrieve user information from the session
$username = $_SESSION['username'];
$usersign = $_SESSION['usersign'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Assets/Profile_admin/Userprofile.css">
    <link rel="stylesheet" href="/Assets/Profile_admin/Logout.css">
    <title>User Profile | Admin</title>
</head>
<body>

  <main class="main-User">
    <!--Section Here  -->
    <section class="parent-User">
      
        <div class="user-button-Log-out">
          <button class="button2" id="Back">
             Back
          </button>  
        </div>
        
      <form class="input" >
        <h1 style="color: rgb(90, 90, 90);" >Welcome Admin!</h1>

        <label for="fullName" class="fullName">User:</label>
        <input type="text" id="fullName" name="fullName" value="<?php echo htmlspecialchars($usersign); ?>" readonly>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" readonly>

      </form>

    </section>

  </main>
</body>
  <!-- Connection -->
  <script>
      // This is Btn Back

  var Back = document.getElementById("Back");

  Back.addEventListener("click", function() {
    // Redirect to /Assets/Admin_Dashboard/Dashboard.html" directly
    window.location.href = "/Assets/Admin_Dashboard/Dashboard.html";
  });
  </script>

</html>
