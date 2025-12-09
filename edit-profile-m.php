<?php
//session start
session_start();

// Include database connection
include_once('db-connect.php');
// Check if the user is logged in by verifying session variables
if (!isset($_SESSION['user_id'])) {
  // If user is not logged in, redirect to login page
  header('Location: marchant-login.php');
  exit(); // Stop further execution
}
// Updating the User Information
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
  // Get form data from POST request
  $id = $_POST['id'];  
  $name = $_POST['name'];  
  $email = $_POST['email'];  
  $phone = $_POST['phone'];  

  // Initialize image update query as an empty string (it will be used only if a new image is uploaded)
  $image_query = "";
  // Check if an image file has been selected by the user
  if (!empty($_FILES['profile_image']['name'])) {

    // Define the directory where images will be uploaded
    $upload_dir = "uploads/";  
    // Generate a unique file name using timestamp to prevent overwriting existing files
    $image_name = time() . "_" . basename($_FILES['profile_image']['name']);  
    // Define the target file path
    $target_file = $upload_dir . $image_name;
    // Move the uploaded file to the server directory
    if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)) {
        // If the file is uploaded successfully, include profile_image in the update query
        $image_query = ", profile_image = '$image_name'";
    }
  }
  // Construct the SQL query to update user details
  // If an image was uploaded, $image_query will be included; otherwise, it remains empty
  $update_query = "UPDATE merchants SET name = '$name', email = '$email', mobile = '$phone' $image_query WHERE id = $id";
  // Execute the SQL update query
  if ($conn->query($update_query) === TRUE) {
    // Success message if the profile is updated successfully
    $msgs =  "<span style='color: green; font-weight: bold;'>Profile updated successfully</span>";
  } else {
    // Error message if there was an issue with the update
    $msgs =  "<span style='color: red; font-weight: bold;'>Error updating profile: " . $conn->error . "</span>";
  }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Mirchi CRM Admin Panel" />
  <meta name="keywords" content="Mirchi CRM Admin Panel" />
  <meta name="author" content="Mirchi CRM" />
  <title>Mirchi CRM - Premium Admin Template</title>
  <!-- Favicon icon-->
  <link rel="icon" href="assets/images/favicon.png" type="image/x-icon" />
  <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon" />
  <!-- Google font-->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="" />
  <link
    href="https://fonts.googleapis.com/css2?family=Nunito+Sans:opsz,wght@6..12,200;6..12,300;6..12,400;6..12,500;6..12,600;6..12,700;6..12,800;6..12,900;6..12,1000&amp;display=swap"
    rel="stylesheet" />
  <!-- Flag icon css -->
  <link rel="stylesheet" href="assets/css/vendors/flag-icon.css" />
  <!-- iconly-icon-->
  <link rel="stylesheet" href="assets/css/iconly-icon.css" />
  <link rel="stylesheet" href="assets/css/bulk-style.css" />
  <!-- iconly-icon-->
  <link rel="stylesheet" href="assets/css/themify.css" />
  <!--fontawesome-->
  <link rel="stylesheet" href="assets/css/fontawesome-min.css" />
  <!-- Whether Icon css-->
  <link rel="stylesheet" type="text/css" href="assets/css/vendors/weather-icons/weather-icons.min.css" />
  <link rel="stylesheet" type="text/css" href="assets/css/vendors/scrollbar.css" />
  <link rel="stylesheet" type="text/css" href="assets/css/vendors/slick.css" />
  <link rel="stylesheet" type="text/css" href="assets/css/vendors/slick-theme.css" />
  <!-- App css -->
  <link rel="stylesheet" href="assets/css/style.css" />
  <link id="color" rel="stylesheet" href="assets/css/color-1.css" media="screen" />
  <style>
    .error-message {
      color: red;
    }
    .show-hide {
    position: absolute;
    right: 345px;
    top: 150px;
    transform: translateY(-50%);
}
  </style>
</head>

<body>
  <!-- page-wrapper Start-->
  <!-- tap on top starts-->
  <div class="tap-top"><i class="iconly-Arrow-Up icli"></i></div>
  <!-- tap on tap ends-->
  <!-- loader-->
  <!-- <div class="loader-wrapper">
    <div class="loader"><span></span><span></span><span></span><span></span><span></span></div>
  </div> -->
  <div class="page-wrapper compact-wrapper" id="pageWrapper">
    <?php
    // Include the header file to load the common header section of the webpage
    // This helps in maintaining a consistent layout across multiple pages
    include 'marchant-header.php';
    ?>
    <!-- Page Body Start-->
    <div class="page-body-wrapper">
      <!-- Page sidebar start-->
      <?php
      // Include the sidebar file to display the navigation menu or additional content
      // This ensures consistency across multiple pages
      include 'marchant-sidebar.php';
      ?>
      <!-- Page sidebar end-->
      <div class="page-body">
        <div class="container-fluid">
          <div class="page-title">
            <div class="row">
              <div class="col-sm-6 col-12">
                <h2>Edit Profile</h2>
                <p class="mb-0 text-title-gray">Welcome back! Let’s start from where you left.</p>
              </div>
              <div class="col-sm-6 col-12">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item text-bold"><a href="index.php">Dashboard</a></li>
                  <li class="breadcrumb-item active">Edit Profile</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid default-dashboard">
          <div class="row">

            <div class="col-xl-12">
            <?php
                $sql = "select * from merchants where id='" . $_SESSION['user_id'] . "'";
                $res = mysqli_query($conn, $sql);
                $rows = mysqli_fetch_array($res);

                $name = $rows['name'];
                $email = $rows['email'];
                $phone = $rows['mobile'];
                $username = $rows['username'];
                $password = $rows['password'];
                $profile_image = $rows["profile_image"];

                ?>
              <form class="card" id="loginForm" enctype="multipart/form-data" method="post" action="#">
                <div class="card-body">
                <?php
                    // Check if the $msgs variable is set (i.e., a message is available to display)
                    if (isset($msgs)) {
                        // If $msgs is set, echo its value directly (without wrapping it in <p> tags)
                        echo '<div id="msg">' . $msgs . '</div>';
                    }
                  ?>
                  <div class="row">
                    <div class="col-md-4">
                      <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input class="form-control" type="text"  name="name" value="<?php echo $name; ?>" />
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                      <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input class="form-control" type="email"  name="email" value="<?php echo $email; ?>" />
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                      <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input class="form-control" type="text"  name="phone" value="<?php echo $phone; ?>" />
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                      <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input class="form-control" type="text" name="username" value="<?php echo $username; ?>"  readonly/>
                      </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                      <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input class="form-control" type="password" name="password" value="<?php echo $password; ?>" readonly/>
                        <div class="show-hide"><span class="show"></span></div>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="mb-3">
                        <label class="form-label">Profile</label>
                        <input class="form-control" type="file" name="profile_image" accept="image/*">
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-sm-6"></div>
                      <div class="col-sm-6">
                        <img src="uploads/<?php echo $profile_image; ?>" alt="Profile Photo" height="150px" width="150px"
                          class="rounded-circle">
                      </div>
                    </div>
                  </div>

                </div>
                <div id="response" class="text-success"></div>
                <div class="card-footer text-center">
                  <input type="hidden" name="id" value="<?php echo $rows["id"] ?>">
                  <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                  <button type="button" onclick="goBack()" class="btn btn-outline-primary">Cancel</button>
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>
      <!-- Page Footer -->
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
  <!-- Show Password -->
  <script src="assets/js/password.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
  <script>
    $(document).ready(function () {
      // Initialize form validation on the login form
      $("#loginForm").validate({
        rules: {
          name: {
            required: true,
            minlength: 3
          },
          email: {
            required: true,
            email: true
          },
          phone: {
            required: true,
            minlength: 10,
            maxlength: 15,
            digits: true
          },
          username: {
            required: true,
            minlength: 3
          },
          password: {
            required: true,
            minlength: 6
          },

        },
        messages: {
          name: {
            required: "Please enter your name.",
            minlength: "Your name must be at least 3 characters long."
          },
          email: {
            required: "Please enter your email.",
            email: "Please enter a valid email address."
          },
          phone: {
            required: "Please enter your phone number.",
            minlength: "Your phone number must be at least 10 digits.",
            maxlength: "Your phone number must not exceed 15 digits.",
            digits: "Please enter a valid phone number."
          },
          username: {
            required: "Please enter your username.",
            minlength: "Your username must be at least 3 characters long."
          },
          password: {
            required: "Please enter your password.",
            minlength: "Your password must be at least 6 characters long."
          },

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
      $("input").on("keyup", function () {
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