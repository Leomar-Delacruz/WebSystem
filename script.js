function login() {
  var username = document.getElementById('username').value;
  var password = document.getElementById('password').value;

  // Send login data to a PHP script for validation
  var xhr = new XMLHttpRequest();
  xhr.open('POST', 'login.php', true);
  xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
  xhr.onreadystatechange = function () {
      if (xhr.readyState == 4 && xhr.status == 200) {
          var response = JSON.parse(xhr.responseText);
          if (response.success) {
              // Redirect to the appropriate page based on the role
              if (response.role === 'admin') {
                  window.location.href = '/Admin_Dashboard/admin.html';
              } else {
                  window.location.href = '/Employee_Dashboard/Employee.html';
              }
          } else {
              // Display an alert for login failure
              alert('Login failed. Please check your username and password.');
          }
      }
  };
  xhr.send('username=' + username + '&password=' + password);
}
