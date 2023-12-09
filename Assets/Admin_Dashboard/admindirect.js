

  function redirectTouserprofile() {
    window.location.href = '/Assets/Profile_admin/userProfile.php'; // Todo actual file path
  }

  function redirectToproducts() {
    window.location.href = '/Assets/Admin_Dashboard/product.php'; // Todo actual file path
  }


  function redirectviewtransacrtion() {
      window.location.href = 'Assets/Admin_Dashboard/transaction.php'; // Todo actual file path
    }

  function redirectTosuppliers() {
    window.location.href = '/supplierlist.php'; // Todo actual file path
  }


  // This is Btn Logout 


  function confirmLogout() {
    // Display a confirmation dialog
    var result = window.confirm("Are you sure you want to logout?");

    // Check the user's choice
    if (result) {
      // User clicked "OK" (Yes), redirect to a specific URL
      alert("You have been logged out!");
      window.location.href = "/index.php";  
    } else {
      // User clicked "Cancel", do nothing or handle accordingly
    }
  }

