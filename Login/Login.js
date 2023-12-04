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
                  window.location.href = ''; //Todo
              } else {  
                  window.location.href = ''; //Todo
              }
          } else {
              // Display login failure message in the center
              loginFailureMessage.innerHTML = 'Login failed. Please check your username and password.';
              loginFailureMessage.style.display = 'block';

              // Hide the message after 1 sec
              setTimeout(function () {
                  loginFailureMessage.style.display = 'none';
              }, 2500);
          }
      }
  };
  xhr.send('username=' + username + '&password=' + password);
}
