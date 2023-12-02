function login() {
  var username = document.getElementById('username').value;
  var password = document.getElementById('password').value;
  var loginFailureMessage = document.getElementById('loginFailureMessage');

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
              // Display login failure message with smooth fade effect
              loginFailureMessage.innerHTML = 'Login failed. Please check your username and password.';
              loginFailureMessage.style.opacity = '1';
              loginFailureMessage.style.visibility = 'visible';

              // Hide the message after 2 seconds
              setTimeout(function () {
                  loginFailureMessage.style.opacity = '0';
                  loginFailureMessage.style.visibility = 'hidden';
              }, 2000);
          }
      }
  };
  xhr.send('username=' + username + '&password=' + password);
}
