<?php
// Start the session to track user data across pages
session_start();
// Store the current page URL in session to track last visited page
$_SESSION['last_page'] = $_SERVER['REQUEST_URI'];
// Include the database connection file
include_once('db-connect.php');

// Check if the user is logged in by verifying session variables
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    // If user is not logged in, redirect to login page
    header('Location: login.php');
    exit(); // Stop further execution
}
if (isset($_REQUEST['submit'])) {
  // Get the user ID from the request
  $id = $_REQUEST['id'];  
  // Get the current password entered by the user
  $old_password = $_POST['currentPassword'];  
  // Get the new password entered by the user
  $new_password = $_POST['newPassword'];

  // SQL query to check if the current password matches the one in the database for the given user ID
  $check_query = "SELECT * FROM admin WHERE id = $id AND password = '$old_password'";

  // Execute the query to check if the user exists with the provided old password
  $result = $conn->query($check_query);

  // If the query returns a result (i.e., the old password matches)
  if ($result->num_rows > 0) {
      // Prepare the SQL query to update the user's password
      $update_query = "UPDATE admin SET password = '$new_password' WHERE id = $id";

      // Execute the update query to change the password
      if ($conn->query($update_query) === TRUE) {
          // Success message if password update is successful
          $msgs = "<span style='color: green; font-weight: bold;'>Your password was updated successfully</span>";
      } else {
          // Error message if there was a problem executing the update query
          $msge = "<span style='color: red; font-weight: bold;'>Error updating password: " . $conn->error . "</span>";
      }
  } else {
      // Error message if the old password does not match
      $msgs = "<span style='color: red; font-weight: bold;'>Incorrect old password</span>";
  }

}
?>
<!DOCTYPE html >
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="description" content="Mirchi CRM Admin Panel"/>
    <meta name="keywords" content="Mirchi CRM Admin Panel"/>
    <meta name="author" content="Mirchi CRM"/>
    <title>Mirchi CRM - Premium Admin Template</title>
    <!-- Favicon icon-->
    <link rel="icon" href="assets/images/favicon.png" type="image/x-icon"/>
    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon"/>
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin=""/>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:opsz,wght@6..12,200;6..12,300;6..12,400;6..12,500;6..12,600;6..12,700;6..12,800;6..12,900;6..12,1000&amp;display=swap" rel="stylesheet"/>
    <!-- Flag icon css -->
    <link rel="stylesheet" href="assets/css/vendors/flag-icon.css"/>
    <!-- iconly-icon-->
    <link rel="stylesheet" href="assets/css/iconly-icon.css"/>
    <link rel="stylesheet" href="assets/css/bulk-style.css"/>
    <!-- iconly-icon-->
    <link rel="stylesheet" href="assets/css/themify.css"/>
    <!--fontawesome-->
    <link rel="stylesheet" href="assets/css/fontawesome-min.css"/>
    <!-- Whether Icon css-->
    <link rel="stylesheet" type="text/css" href="assets/css/vendors/weather-icons/weather-icons.min.css"/>
    <link rel="stylesheet" type="text/css" href="assets/css/vendors/scrollbar.css"/>
    <link rel="stylesheet" type="text/css" href="assets/css/vendors/slick.css"/>
    <link rel="stylesheet" type="text/css" href="assets/css/vendors/slick-theme.css"/>
    <!-- App css -->
    <link rel="stylesheet" href="assets/css/style.css"/>
    <link id="color" rel="stylesheet" href="assets/css/color-1.css" media="screen"/>
    <style>
      .error-message{
        color:red;
      }
    </style>
  </head>
  <body>
    <!-- page-wrapper Start-->
    <!-- tap on top starts-->
    <div class="tap-top"><i class="iconly-Arrow-Up icli"></i></div>
    <!-- tap on tap ends-->
    <!-- loader-->
    <div class="loader-wrapper">
      <div class="loader"><span></span><span></span><span></span><span></span><span></span></div>
    </div>
    <div class="page-wrapper compact-wrapper" id="pageWrapper"> 
     <!-- Page header -->
     <?php 
        // Include the header file to load the common header section of the webpage
        // This helps in maintaining a consistent layout across multiple pages
        include 'header.php'; 
      ?>
      <!-- Page Body Start-->
      <div class="page-body-wrapper"> 
        <!-- Page sidebar start-->
        <?php 
          // Include the sidebar file to display the navigation menu or additional content
          // This ensures consistency across multiple pages
          include 'sidebar.php'; 
        ?>
        <!-- Page sidebar end-->
        <div class="page-body">
          <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-sm-6 col-12"> 
                  <h2>Password Change </h2>
                  <p class="mb-0 text-title-gray">Welcome back! Let’s start from where you left.</p>
                </div>
                <div class="col-sm-6 col-12">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item text-bold"><a href="index.php">Dashboard</a></li>
                    <li class="breadcrumb-item active">Password Change</li>
                  </ol>
                </div>
              </div>
            </div>
          </div>
          <!-- Container-fluid starts-->
          <div class="container-fluid default-dashboard">
            <div class="row">
              <div class="card">
                <div class="col-md-5 mx-auto m-3">
                  <!-- Printing Message -->
                  <?php
                    // Check if the $msgs variable is set (i.e., a message is available to display)
                    if (isset($msgs)) {
                        // If $msgs is set, echo its value directly (without wrapping it in <p> tags)
                        echo '<div id="msg" style="color: green;">' . $msgs . '</div>';
                    }
                  ?>
                  <form class="theme-form" id="loginForm" method="POST">
                        <input type="hidden" class="form-control mb-2 mr-sm-4" name="id" value="<?php echo $_SESSION['user_id'] ?>">
                    <!-- <h2 class="text-center">Change Password</h2> -->
            
                    <div class="form-group">
                      <label class="col-form-label">Old Password</label>
                      <input class="form-control" type="Password" name="currentPassword">
                    </div>
                    <div class="form-group">
                      <label class="col-form-label">New Password</label>
                      <input class="form-control" type="Password" name="newPassword">
                    </div>
                    <div class="form-group">
                      <label class="col-form-label">Re-enter New Password</label>
                      <input class="form-control" type="Password" name="rePassword">
                    </div>
                    <div class="form-group mb-0 checkbox-checked">
                      <div class="text-end mt-3">
                        <button class="btn btn-primary btn-block w-100" type="submit" name="submit">Submit</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php 
          // Include the footer file to add the consistent footer section across all pages
          // This ensures uniformity and saves time by not duplicating footer code on each page
          include 'footer.php'; 
        ?>
      </div>
    </div>
    <!-- jquery-->
    <script src="assets/js/vendors/jquery/jquery.min.js"></script>
    <!-- bootstrap js-->
    <script src="assets/js/vendors/bootstrap/dist/js/bootstrap.bundle.min.js" defer=""></script>
    <script src="assets/js/vendors/bootstrap/dist/js/popper.min.js" defer=""></script>
    <!--fontawesome-->
    <script src="assets/js/vendors/font-awesome/fontawesome-min.js"></script>
    <!-- feather-->
    <script src="assets/js/vendors/feather-icon/feather.min.js"></script>
    <script src="assets/js/vendors/feather-icon/custom-script.js"></script>
    <!-- sidebar -->
    <script src="assets/js/sidebar.js"></script>
    <!-- height_equal-->
    <script src="assets/js/height-equal.js"></script>
    <!-- config-->
    <script src="assets/js/config.js"></script>
    <!-- apex-->
    <script src="assets/js/chart/apex-chart/apex-chart.js"></script>
    <script src="assets/js/chart/apex-chart/stock-prices.js"></script>
    <!-- scrollbar-->
    <script src="assets/js/scrollbar/simplebar.js"></script>
    <script src="assets/js/scrollbar/custom.js"></script>
    <!-- slick-->
    <script src="assets/js/slick/slick.min.js"></script>
    <script src="assets/js/slick/slick.js"></script>
    <!-- data_table-->
    <script src="assets/js/js-datatables/datatables/jquery.dataTables.min.js"></script>
    <!-- page_datatable-->
    <script src="assets/js/js-datatables/datatables/datatable.custom.js"></script>
    <!-- page_datatable1-->
    <script src="assets/js/js-datatables/datatables/datatable.custom1.js"></script>
    <!-- page_datatable-->
    <script src="assets/js/datatable/datatables/datatable.custom.js"></script>
    <!-- theme_customizer-->
    <script src="assets/js/theme-customizer/customizer.js"></script>
    <!-- tilt-->
    <script src="assets/js/animation/tilt/tilt.jquery.js"></script>
    <!-- page_tilt-->
    <script src="assets/js/animation/tilt/tilt-custom.js"></script>
    <!-- dashboard_1-->
    <script src="assets/js/dashboard/dashboard_1.js"></script>
    <!-- custom script -->
    <script src="assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script>
$(document).ready(function () {
  // Initialize form validation on the login form
  $("#loginForm").validate({
    rules: {
      currentPassword: {
        required: true,// Old password is required
        minlength: 6 // Minimum length should be 6 characters
      },
      newPassword: {
        required: true, // New password is required
        minlength: 6  // Minimum length should be 6 characters
      },
      rePassword: {
        required: true, // Re-enter password is required
        equalTo: "[name='newPassword']" // Must match new password field
      }
    },
    messages: {
      currentPassword: {
        required: "Please enter your current password.",
        minlength: "Your current password must be at least 6 characters long."
      },
      newPassword: {
        required: "Please enter a new password.",
        minlength: "Your new password must be at least 6 characters long."
      },
      rePassword: {
        required: "Please re-enter your new password.",
        equalTo: "The re-entered password must match the new password."
      }
    },
    errorElement: "span",              // Error messages will be inside <span> tags
    errorClass: "error-message",       // Assign class to the error message
    highlight: function (element) {
      $(element).addClass("is-invalid"); // Add class to highlight invalid fields
    },
    unhighlight: function (element) {
      $(element).removeClass("is-invalid"); // Remove class when field is valid
    }
  });

  // Bind the keypress event to the form fields
  $("input").on("keyup", function() {
    $(this).valid(); // Trigger validation on the specific field
  });
});

// ***********************Message Timeout Function *******************
// ===================================================================
  // JavaScript to hide the message after 5 seconds (5000ms)
  setTimeout(function() {
  var msgElement = document.getElementById('msg');
  if (msgElement) {
    msgElement.style.display = 'none'; // Hide the message
  }
  }, 5000); // 5000 milliseconds = 5 seconds
</script>

  </body>
</html>