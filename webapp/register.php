<?php

session_start();
include 'db.php'; // Include your database connection

?>

<?php
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Check if all input fields are filled
  if (!empty($_POST['lname']) && !empty($_POST['fname']) && !empty($_POST['address']) && !empty($_POST['bloodtype']) && !empty($_POST['persontocontact']) && !empty($_POST['addrpersontocontact']) && !empty($_POST['telnopersontocontact']) && !empty($_POST['username']) && !empty($_POST['password'])) {
      // Retrieve and escape form data to prevent SQL injection
      $lname = $conn->real_escape_string($_POST['lname']);
      $fname = $conn->real_escape_string($_POST['fname']);
      $address = $conn->real_escape_string($_POST['address']);
      $bloodType = $conn->real_escape_string($_POST['bloodtype']);
      $personToContact = $conn->real_escape_string($_POST['persontocontact']);
      $addressPersonToContact = $conn->real_escape_string($_POST['addrpersontocontact']);
      $telNoPersonToContact = $conn->real_escape_string($_POST['telnopersontocontact']);
      $username = $conn->real_escape_string($_POST['username']);
      $password = $conn->real_escape_string($_POST['password']);
      $accessrights="user";
      // SQL INSERT statement
      $sql = "INSERT INTO users (lname, fname, address, bloodtype, persontocontact, addrpersontocontact, username, password, telnopersontocontact, accessrights) 
      VALUES ('$lname', '$fname', '$address', '$bloodType', '$personToContact', '$addressPersonToContact', '$username', '$password', '$telNoPersonToContact', '$accessrights')";
      
      // Attempt to execute the query
      if ($conn->query($sql) === TRUE) {
          echo "Information updated successfully.";
          $_SESSION['success_message'] = 'Information updated successfully.';
          // Redirect to userinfo.php
          $_SESSION['fullname'] = $fname . ' ' . $lname;
          header('Location: userinfo.php');
          $conn->close();
          exit;
          // Redirect or take other action as needed
      } else {
        echo "<script>alert('Error updating record: " . $conn->error . "');</script>";
      }
  } else {
    echo "<script>alert('All input fields are required.');</script>";
  }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Smart Helmet </title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="../../assets/vendors/feather/feather.css">
  <link rel="stylesheet" href="../../assets/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../../assets/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="../../assets/vendors/typicons/typicons.css">
  <link rel="stylesheet" href="../../assets/vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="../../assets/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../../assets/css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../../assets/images/favicon.png" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <!-- <div class="brand-logo">
                <img src="../../assets/images/logo.svg" alt="logo">
              </div> -->
              <h4>Register New Account</h4>
              
              <form method="POST" action="register.php">
                <div class="col-md-18 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body">
                        <h4 class="card-title">Personal Information</h4>
                        
                        <form class="forms-sample">
                          <div class="form-group">
                            <label for="Inputlname">Last Name</label>
                            <input type="text" class="form-control" id="Inputlname" name="lname" placeholder="LastName">
                            

                          </div>
                          <div class="form-group">
                            <label for="Inputfname">First Name</label>
                            <input type="text" class="form-control" id="Inputfname" name="fname" placeholder="FirstName">
                          </div>

                          <div class="form-group">
                              <label for="InputBloodType">Blood Type</label>
                              <select class="form-control" id="InputBloodType" name="bloodtype">
                                  <option value="A" >A</option>
                                  <option value="B" >B</option>
                                  <option value="AB">AB</option>
                                  <option value="O" >O</option>
                              </select>
                          </div>


                          <div class="form-group">
                            <label for="InputUserAddress">Address</label>
                            <input type="text" class="form-control" id="InputUserAddress" name="address" placeholder="UserAddress" >
                          </div>

                      
              
                          <div class="form-group">
                            <label for="InputPersonToContact">Person To Contact In Case of Emegency</label>
                            <input type="text" class="form-control" id="InputPersonToContact" name="persontocontact" placeholder="PersonToContact"  >
                          </div>


                          <div class="form-group">
                            <label for="InputPersonToContactAddress">Address Of Person To Contact In Case of Emegency</label>
                            <input type="text" class="form-control" id="InputPersonToContactAddress" name="addrpersontocontact" placeholder="PersonToContactAddress" >
                          </div>

                    
                          <div class="form-group">
                            <label for="InputPersonToContactNumber">Contact Number Of Person To Contact In Case of Emegency</label>
                            <input type="text" class="form-control" id="InputPersonToContactNumber" name="telnopersontocontact" placeholder="PersonToContactNumber" >
                          </div>


                          <div class="form-group">
                            <label for="InputUsername">User Name</label>
                            <input type="text" class="form-control" id="InputUsername" name="username" placeholder="User Name" >
                          </div>
                          

                          <div class="form-group">
                            <label for="InputPassword">Password</label>
                            <input type="password" class="form-control" id="InputPassword" name="password" placeholder="Password" >
                          </div>


                          <!-- <a href="userinfo_edit.php" class="btn btn-primary me-2">Save Information</a> -->
                          <button type="submit" class="btn btn-primary me-2">Save Information</button>
                          <button type="button" class="btn btn-secondary me-2" onclick="window.location.href='login.php';">  Cancel  </button>

                          <!-- <button class="btn btn-light">Cancel</button> -->
                        </form>
                      </div>
               </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="../../assets/vendors/js/vendor.bundle.base.js"></script>
  <script src="../../assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="../../assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="../../assets/js/off-canvas.js"></script>
  <script src="../../assets/js/hoverable-collapse.js"></script>
  <script src="../../assets/js/template.js"></script>
  <script src="../../assets/js/settings.js"></script>
  <script src="../../assets/js/todolist.js"></script>
  <!-- endinject -->
</body>

</html>