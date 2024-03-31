<?php
session_start();
include 'db.php';


if (!isset($_SESSION['user'])) {
    // If the user is not logged in, redirect to the login page.
    header("Location: login.php");
    exit();
}
$fullname = $_SESSION['fullname']; 
// The rest of your index.php code goes here.
// This part will only run if the user is logged in.
$ctrno=$_SESSION['ctrno'];


$sql = "SELECT * FROM deviceassignment WHERE ctrno = '$ctrno'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
      // Fetch the user data
      $user = $result->fetch_assoc();

       $deviceid= $user['deviceid'];
      // User exists, proceed to login
     
  } else {
      // User doesn't exist, display an error message
      echo "<script>alert('Device ID not Found');</script>";
      
      $deviceid="0000";
  }

  
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete'])) {
        $deleteCtrNo = $_POST['delete_ctrno']; // Change to delete_ctrno
        // Perform deletion query
        $sqlDelete = "DELETE FROM deviceassignment WHERE ctrno = '$deleteCtrNo'"; // Change to ctrno
        if ($conn->query($sqlDelete) === TRUE) {
            echo "<script>alert('Device deleted successfully');</script>";
            // Redirect back to the page where you display the device list
            header("Location: devicelist.php");
            exit();
        } else {
            echo "<script>alert('Error deleting device: " . $conn->error . "');</script>";
        }
    } else {
        // Validate and sanitize input
        if(isset($_POST['deviceid']) && isset($_POST['description'])) {
            $deviceid = $_POST['deviceid'];
            $description = $_POST['description'];

            // Perform SQL insertion
            $sql = "INSERT INTO deviceassignment (deviceid, description, userctr) VALUES ('$deviceid', '$description', $ctrno)";

            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('New device added successfully');</script>";
                // Redirect back to the page where you display the device list
                header("Location: devicelist.php");
                exit();
            } else {
                echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "');</script>";
            }
        } else {
            echo "<script>alert('Device ID or Description not provided');</script>";
        }
    }
}



// Close the database connection


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Include Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">



  <title>Smart Helmet</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="assets/vendors/feather/feather.css">
  <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
  <link rel="stylesheet" href="assets/vendors/typicons/typicons.css">
  <link rel="stylesheet" href="assets/vendors/simple-line-icons/css/simple-line-icons.css">
  <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css">
  <link rel="stylesheet" type="text/css" href="assets/js/select.dataTables.min.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="assets/css/vertical-layout-light/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="assets/images/favicon.png" />
</head>

<body class="with-welcome-text">
  
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
    <div class="me-3">
      <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
        <span class="icon-menu"></span>
      </button>
    </div>
    <div>
      <a class="navbar-brand brand-logo" href="">
        <img src="../assets/images/" alt="Smart Helmet" />
      </a>
      <!-- <a class="navbar-brand brand-logo-mini" href="../index.php">
        <img src="../assets/images/logo2.svg" alt="logo" />
      </a> -->
    </div>
  </div>
 
  <div class="navbar-menu-wrapper d-flex align-items-top">
    <ul class="navbar-nav">
      <li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
        <h1 class="welcome-text">Welcome, <span class="text-black fw-bold"><?php echo strtoupper($_SESSION['fullname']); ?>

</span></h1>
        
      </li>
    </ul>
    <ul class="navbar-nav ms-auto">
    </ul>
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
      data-bs-toggle="offcanvas">
      <span class="mdi mdi-menu"></span>
    </button>
  </div>
</nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_settings-panel.html -->
      <div class="theme-setting-wrapper">
  <!-- <div id="settings-trigger"><i class="ti-settings"></i></div> -->
  <div id="theme-settings" class="settings-panel">
    <i class="settings-close ti-close"></i>
    <p class="settings-heading">SIDEBAR SKINS</p>
    <div class="sidebar-bg-options selected" id="sidebar-light-theme">
      <div class="img-ss rounded-circle bg-light border me-3"></div>Light
    </div>
    <div class="sidebar-bg-options" id="sidebar-dark-theme">
      <div class="img-ss rounded-circle bg-dark border me-3"></div>Dark
    </div>
    <p class="settings-heading mt-2">HEADER SKINS</p>
    <div class="color-tiles mx-0 px-4">
      <div class="tiles success"></div>
      <div class="tiles warning"></div>
      <div class="tiles danger"></div>
      <div class="tiles info"></div>
      <div class="tiles dark"></div>
      <div class="tiles default"></div>
    </div>
  </div>
</div>
<div id="right-sidebar" class="settings-panel">
  <i class="settings-close ti-close"></i>
  <ul class="nav nav-tabs border-top" id="setting-panel" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" id="todo-tab" data-bs-toggle="tab" href="#todo-section" role="tab"
        aria-controls="todo-section" aria-expanded="true">TO DO LIST</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="chats-tab" data-bs-toggle="tab" href="#chats-section" role="tab"
        aria-controls="chats-section">CHATS</a>
    </li>
  </ul>
  <div class="tab-content" id="setting-content">
    <div class="tab-pane fade show active scroll-wrapper" id="todo-section" role="tabpanel"
      aria-labelledby="todo-section">
      <div class="add-items d-flex px-3 mb-0">
        <form class="form w-100">
          <div class="form-group d-flex">
            <input type="text" class="form-control todo-list-input" placeholder="Add To-do">
            <button type="submit" class="add btn btn-primary todo-list-add-btn" id="add-task">Add</button>
          </div>
        </form>
      </div>
      <div class="list-wrapper px-3">
        <ul class="d-flex flex-column-reverse todo-list">
          <li>
            <div class="form-check">
              <label class="form-check-label">
                <input class="checkbox" type="checkbox">
                Team review meeting at 3.00 PM
              </label>
            </div>
            <i class="remove ti-close"></i>
          </li>
          <li>
            <div class="form-check">
              <label class="form-check-label">
                <input class="checkbox" type="checkbox">
                Prepare for presentation
              </label>
            </div>
            <i class="remove ti-close"></i>
          </li>
          <li>
            <div class="form-check">
              <label class="form-check-label">
                <input class="checkbox" type="checkbox">
                Resolve all the low priority tickets due today
              </label>
            </div>
            <i class="remove ti-close"></i>
          </li>
          <li class="completed">
            <div class="form-check">
              <label class="form-check-label">
                <input class="checkbox" type="checkbox" checked>
                Schedule meeting for next week
              </label>
            </div>
            <i class="remove ti-close"></i>
          </li>
          <li class="completed">
            <div class="form-check">
              <label class="form-check-label">
                <input class="checkbox" type="checkbox" checked>
                Project review
              </label>
            </div>
            <i class="remove ti-close"></i>
          </li>
        </ul>
      </div>
      <h4 class="px-3 text-muted mt-5 fw-light mb-0">Events</h4>
      <div class="events pt-4 px-3">
        <div class="wrapper d-flex mb-2">
          <i class="ti-control-record text-primary me-2"></i>
          <span>Feb 11 2018</span>
        </div>
        <p class="mb-0 font-weight-thin text-gray">Creating component page build a js</p>
        <p class="text-gray mb-0">The total number of sessions</p>
      </div>
      <div class="events pt-4 px-3">
        <div class="wrapper d-flex mb-2">
          <i class="ti-control-record text-primary me-2"></i>
          <span>Feb 7 2018</span>
        </div>
        <p class="mb-0 font-weight-thin text-gray">Meeting with Alisa</p>
        <p class="text-gray mb-0 ">Call Sarah Graves</p>
      </div>
    </div>
    <!-- To do section tab ends -->
    
  </div>
</div>
      <!-- partial -->
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item">
      <a class="nav-link" href="../index.php">
        <i class="mdi mdi-grid-large menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>

<!-- Navigation Menu  -->
<?php 
  include"nav.php"; 
?>

</nav>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-sm-12">
                <!-- This is for the dashboard -->
              <?php
                  
              ?>


              <!-- // This is the panel to put the forms 
                    USER INFO
              -->
              <div class="col-lg-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                <div class="row">
            <div class="col">
                <h4 class="card-title">Device List</h4>
            </div>
            <div class="col-auto">
                <!-- Button to trigger modal -->
                <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target="#addDeviceModal">Add New Device</button>
            </div>
        </div>
        <p class="card-description">
            <div class="table-responsive">
                <!-- Your table code here -->
            </div>
        </p>
                  <div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Ctr</th>
                <th>Device ID</th>
                <th>Description</th>
                <th>Actions</th> <!-- Added a column for the actions -->
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM deviceassignment WHERE userctr=$ctrno"; // Adjust the table name if necessary
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    
                    echo "<tr>
                    <td>" . $row["ctrno"] . "</td>
                    <td>" . $row["deviceid"] . "</td>
                    <td>" . $row["description"] . "</td>
                    <td>
                        <form method='post'>
                            <input type='hidden' name='delete_ctrno' value='" . $row["ctrno"] . "'> <!-- Hidden input for ctrno -->
                            <button type='submit' name='delete' class='btn btn-danger'>Delete</button>
                        </form>
                    </td>
                </tr>";
                
                }
            } else {
                echo "<tr><td colspan='6'>No results found</td></tr>";
            }

            if (isset($_POST['delete'])) {
                $deleteDeviceId = $_POST['delete_deviceid'];
                // Perform deletion query here
                // Example: $sqlDelete = "DELETE FROM gpsinfo WHERE deviceid = $deleteDeviceId";
                // Execute deletion query
            }
            ?>
        </tbody>
    </table>
</div>



                </div>
              </div>
            </div>
              </div>
            </div>
          </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
  <div class="d-sm-flex justify-content-center justify-content-sm-between">
    
    <span class="float-none float-sm-end d-block mt-1 mt-sm-0 text-center">Copyright © 2024. All rights reserved.</span>
  </div>
</footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>

  
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="assets/vendors/js/vendor.bundle.base.js"></script>
  <script src="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="assets/vendors/chart.js/Chart.min.js"></script>
  <script src="assets/vendors/progressbar.js/progressbar.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="assets/js/off-canvas.js"></script>
  <script src="assets/js/hoverable-collapse.js"></script>
  <script src="assets/js/template.js"></script>
  <script src="assets/js/settings.js"></script>
  <script src="assets/js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="assets/js/jquery.cookie.js" type="text/javascript"></script>
  <script src="assets/js/dashboard.js"></script>
  <script src="assets/js/proBanner.js"></script>
  
  
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <!-- <script src="../../assets/js/Chart.roundedBarCharts.js"></script> -->

  <!-- End custom js for this page-->

  <!-- Modal for adding a new device -->
  <div class="modal fade" id="addDeviceModal" tabindex="-1" role="dialog" aria-labelledby="addDeviceModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addDeviceModalLabel">Add New Device</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <!-- Form for adding a new device -->
          <form method="post" action="devicelist.php">
            <div class="form-group">
              <label for="deviceid">Device ID</label>
              <input type="text" class="form-control" id="deviceid" name="deviceid" placeholder="Enter Device ID" required>
            </div>
            <div class="form-group">
              <label for="description">Description</label>
              <input type="text" class="form-control" id="description" name="description" placeholder="Enter Description" required>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
