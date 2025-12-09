<?php
// Start the session
session_start();

// Database connection
include_once('db-connect.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login if not logged in
    header('Location: marchant-login.php');
    exit();
}

// Get merchant ID from session
$merchant_id = $_SESSION['user_id'];

// Prepare the SQL query
$stmt = $conn->prepare("SELECT * FROM merchants WHERE id = ?");
$stmt->bind_param("i", $merchant_id);

// Execute the query
$stmt->execute();
$result = $stmt->get_result();

// Fetch merchant data
if ($result->num_rows > 0) {
    $merchant = $result->fetch_assoc();

    // Add purpose from session
    $merchant['purpose'] = isset($_SESSION['purpose']) ? $_SESSION['purpose'] : null;

    // Optional: Use or print $merchant
    // print_r($merchant);
} else {
    echo "No merchant found with ID: $merchant_id";
}

if(!empty($_REQUEST['hid']) )
{
  if ($_REQUEST['hid'] == 'add') {
    $merchant_id = $_SESSION['user_id'];
    // Prepare the SQL query
    $sql = "INSERT INTO employees (name, email, mobile, username, password, validity, status, address, profile_image, merchant_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare the statement
    $result = mysqli_prepare($conn, $sql);

    if ($result) {
        // Bind the parameters
        mysqli_stmt_bind_param($result, "ssssssssss", $name, $email, $mobile, $username, $password, $validity, $status, $address, $profile_image, $merchant_id);

        // Assign POST values to variables
        $name = $_POST['name'];
        $email = $_POST['email'];
        $mobile = $_POST['mobile'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $validity = $_POST['validity'];
        $status = $_POST['status'];
        $address = $_POST['address'];

        // Handle file upload
        $profile_image = ''; // Default to empty if no file is uploaded

        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
            // Define the target directory and file path
            $target_dir = "uploads/";
            $profile_image = $target_dir . basename($_FILES["profile_image"]["name"]);

            // Check if the file upload was successful
            if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $profile_image)) {
                // File uploaded successfully
                echo "File uploaded successfully.";
            } else {
                // Error uploading the file
                echo "Error uploading file.";
            }
        }

        // Execute the prepared statement
        if (mysqli_stmt_execute($result)) {
            $_SESSION['success_message'] = "Data inserted successfully";
            $_SESSION['flash_color'] = "#052c65";
        } else {
            $_SESSION['success_message'] = "Unable to add data";
            $_SESSION['flash_color'] = "red";
        }
    } else {
        $_SESSION['success_message'] = "Unable to prepare statement";
        $_SESSION['flash_color'] = "red";
    }
}

if ($_REQUEST['hid'] == 'edit') {
    $id = (int)$_POST['id']; // Ensure the ID is an integer

    // Fetch form values
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $validity = $_POST['validity'];
    $status = $_POST['status'];
    $address = $_POST['address'];

    // Check if a new image is uploaded
    if (!empty($_FILES['profile_image']['name'])) {
        $target_directory = "uploads/";
        $profile_image = $target_directory . basename($_FILES['profile_image']['name']);
        $file_tmp = $_FILES['profile_image']['tmp_name'];

        // Attempt to upload
        if (!move_uploaded_file($file_tmp, $profile_image)) {
            $_SESSION['success_message'] = "Error uploading file.";
            $_SESSION['flash_color'] = "red";
            header("Location: manage-employees.php");
            exit();
        }

        // Update with new image
        $sql = "UPDATE employees SET name=?, email=?, mobile=?, username=?, password=?, validity=?, status=?, address=?, profile_image=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'sssssssssi', $name, $email, $mobile, $username, $password, $validity, $status, $address, $profile_image, $id);
    } else {
        // No new image, keep existing
        $sql = "UPDATE employees SET name=?, email=?, mobile=?, username=?, password=?, validity=?, status=?, address=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'ssssssssi', $name, $email, $mobile, $username, $password, $validity, $status, $address, $id);
    }

    // Execute and check
    if ($stmt) {
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            $_SESSION['success_message'] = "Data updated successfully";
            $_SESSION['flash_color'] = "#052c65";
        } else {
            $_SESSION['success_message'] = "No changes made or data is identical";
            $_SESSION['flash_color'] = "orange";
        }

        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['success_message'] = "Error preparing update statement.";
        $_SESSION['flash_color'] = "red";
    }

    // Redirect after update
    header("Location: manage-employees.php");
    exit();
}



if($_REQUEST['hid'] == 'delete')
{
    //Delete course sql query goes here
    $id_to_update = $_REQUEST['id']; 
    $new_value = 0;
    // Prepare and execute the SQL statement
    $sql = "UPDATE employees SET option = '$new_value' WHERE id = $id_to_update";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['success_message'] = "Data Delete successfully";
        $_SESSION['flash_color'] = "#052c65";          
    } else {
        $_SESSION['success_message'] = "Unable to Delete Data";
        $_SESSION['flash_color'] = "red";
    }
}
  header('Location: manage-employees.php');
    exit();
}
//Recard Adding  Message with Lightbox Effect
if (isset($_SESSION['success_message']) && isset($_SESSION['flash_color'])) {
    // Display the success message in a lightbox-style modal window
    echo '<div id="myModal" class="lightbox">
            <div class="modal-content">
                <span class="close-button" onclick="closeModal()">&times;</span>
                <p style="color: ' . $_SESSION['flash_color'] . '">' . $_SESSION['success_message'] . '</p>
            </div>
          </div>';
    // Clear the success message from the session
    unset($_SESSION['success_message']);
       // JavaScript to redirect after a delay
    echo '<script>
            setTimeout(function() {
                window.location.href = "manage-employees.php"; // Change "redirect_page.php" to the desired page URL
            }, 1000); // Adjust the delay (in milliseconds) as needed
          </script>';
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Mirchi CRM Admin Panel"/>
    <meta name="keywords" content="Mirchi CRM Admin Panel"/>
    <meta name="author" content="Mirchi CRM"/>
    <title>Mirchi CRM - Premium Admin Template</title>
    <!-- Favicon icon-->
    <link rel="icon" href="assets/images/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon">
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:opsz,wght@6..12,200;6..12,300;6..12,400;6..12,500;6..12,600;6..12,700;6..12,800;6..12,900;6..12,1000&amp;display=swap" rel="stylesheet">
    <!-- Flag icon css -->
    <link rel="stylesheet" href="assets/css/vendors/flag-icon.css">
    <!-- iconly-icon-->
    <link rel="stylesheet" href="assets/css/iconly-icon.css">
    <link rel="stylesheet" href="assets/css/bulk-style.css">
    <!-- iconly-icon-->
    <link rel="stylesheet" href="assets/css/themify.css">
    <!--fontawesome-->
    <link rel="stylesheet" href="assets/css/fontawesome-min.css">
    <!-- Whether Icon css-->
    <link rel="stylesheet" type="text/css" href="assets/css/vendors/weather-icons/weather-icons.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/vendors/scrollbar.css">
    <link rel="stylesheet" type="text/css" href="assets/css/vendors/datatables.css">
    <link rel="stylesheet" type="text/css" href="assets/css/vendors/slick.css">
    <link rel="stylesheet" type="text/css" href="assets/css/vendors/slick-theme.css">
    <!-- App css -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link id="color" rel="stylesheet" href="assets/css/color-1.css" media="screen">
    <style>
      .error-message{
        color:red;
      }
        .show-hide {
    position: absolute;
    right: 412px;
    top: 195px;
    transform: translateY(-50%);
}
.lightbox {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }
    
    .modal-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #acd4fe;
        padding: 20px;
        border: 1px solid #888;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        text-align: center;
        color: #af1212;
        font-size: 20px;
        font-weight: 600;
    }
    </style>
  </head>
  <body>
    <!-- tap on top starts-->
    <div class="tap-top"><i class="iconly-Arrow-Up icli"></i></div>
    <!-- tap on tap ends-->
    <!-- loader-->
    <div class="loader-wrapper">
      <div class="loader"><span></span><span></span><span></span><span></span><span></span></div>
    </div>
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
    <?php
    // Include the header file to load the common header section of the webpage
    // This helps in maintaining a consistent layout across multiple pages
    include 'marchant-header.php';
    ?>
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
                    <?php
                    // Assume the mode is determined from a query parameter, URL, or form data
                    $mode = isset($_GET['mode']) ? $_GET['mode'] : 'add';  // Default to 'add' if no mode is specified
                    ?>
                    
                    <div class="col-sm-6 col-12">
                      <h2>
                        <?php
                        // Set the title based on the mode
                        if ($mode == 'add') {
                          echo 'Add New Employee';  // Title for adding a new merchant
                        } elseif ($mode == 'edit') {
                          echo 'Update Employee Profile';  // Title for editing an existing merchant
                        } else {
                          echo 'Merchants Details';  // Default title, if needed
                        }
                        ?>
                      </h2>
                      <p class="mb-0 text-title-gray">Welcome back! Let’s start from where you left.</p>
                    </div>
                    <div class="col-sm-6 col-12">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item text-bold"><a href="index-m.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">
                          <?php
                          // Set breadcrumb based on the mode
                          if ($mode == 'add') {
                            echo 'Add Employee';
                          } elseif ($mode == 'edit') {
                            echo 'Edit Employee';
                          } else {
                            echo 'Employee Profile';
                          }
                          ?>
                        </li>
                      </ol>
                    </div>

              </div>
            </div>
          </div>
          <!-- Container-fluid starts-->
          <div class="container-fluid">
            <div class="row">
              <!-- Zero Configuration  Starts-->
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-body">

                  <form class="card" id="loginForm" enctype="multipart/form-data" method="post">
                  <?php
                               if($_REQUEST["mode"] == "edit" ){
                                $sql = "select * from employees where id='".$_REQUEST['id']."'";
                                $res = mysqli_query($conn,$sql);
                                $rows = mysqli_fetch_array($res);

                                $name = $rows["name"];
                                $email = $rows["email"];
                                $mobile = $rows["mobile"];
                                $username = $rows["username"];
                                $password = $rows["password"];
                                $validity = $rows["validity"];
                                $address = $rows["address"];
                                $profile_image = $rows["profile_image"];
                                $status = $rows["status"];
                               
                            }else{
                              $name = "";
                              $email ="";
                              $mobile ="";
                              $username = "";
                              $password ="";
                              $validity = "";
                              $address = "";
                              $profile_image = "";
                              $status = "";
                                $rows["id"] = '';
                            }
                            ?> 
              <div class="card-header card-no-border pb-0">
        
                <div class="card-options"><a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a></div>
              </div>
      
              <div class="card-body">
                <div class="row">
                  <div class="col-md-4">
                    <div class="mb-3">
                      <label class="form-label">Name</label>
                      <input class="form-control" type="text" placeholder="Name" name="name" value="<?php echo $name;?>"/>
                    </div>
                  </div>
                  <div class="col-sm-6 col-md-4">
                    <div class="mb-3">
                      <label class="form-label">Email</label>
                      <input class="form-control" type="email" placeholder="Email" name="email" value="<?php echo $email;?>"/>
                    </div>
                  </div>
                  <div class="col-sm-6 col-md-4">
                    <div class="mb-3">
                      <label class="form-label">Phone</label>
                      <input class="form-control" type="text" placeholder="Phone" name="mobile" value="<?php echo $mobile;?>"/>
                    </div>
                  </div>
                  <div class="col-sm-6 col-md-4">
                    <div class="mb-3">
                      <label class="form-label">Username</label>
                      <input class="form-control" type="text" placeholder="Username" name="username" value="<?php echo $username;?>"/>
                    </div>
                  </div>
                  <div class="col-sm-6 col-md-4">
                    <div class="mb-3">
                      <label class="form-label">Password</label>
                      <input class="form-control" type="password" placeholder="Password" name="password"value="<?php echo $password;?>" />
                     <span class="show-hide"><span class="show"></span></span>
                    </div>
                  </div>
                  <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label" for="validationTooltip04">Validity</label>
                    <select class="form-select" id="validationTooltip04" name="validity" required="">
                        <!-- Placeholder option shown first -->
                        <option disabled value="" <?php echo (!isset($rows['validity']) || empty($rows['validity'])) ? 'selected' : ''; ?>>Choose Validity</option>
            
                        <?php
                        // Define the validity options
                        $validityOptions = [
                            "1 Month", "2 Months", "3 Months", "4 Months", "5 Months", 
                            "6 Months", "7 Months", "8 Months", "9 Months", "10 Months", 
                            "11 Months", "12 Months"
                        ];
            
                        // If in edit mode, set the selected validity; in add mode, it's empty
                        $selectedValidity = (isset($_REQUEST["mode"]) && $_REQUEST["mode"] == "edit" && isset($rows['validity'])) ? $rows['validity'] : '';
            
                        // Loop through the options and mark the one that matches (only in edit mode)
                        foreach ($validityOptions as $option) {
                            $selected = ($option == $selectedValidity) ? 'selected' : '';
                            echo "<option value='$option' $selected>$option</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>

                  <div class="col-4">
                        <label class="form-label" for="exampleFormControlTextarea1">Address</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="2" style="height:40px;" name="address"><?php echo $address;?></textarea>
                </div>
                <div class="col-md-4">
                          <div class="mb-3">
                            <label class="form-label">Profile</label>
                            <input class="form-control" type="file" name="profile_image" accept="image/*">
                          </div>
                        </div>
                <div class="col-md-6 col-xl-4">
                <label class="form-label" for="exampleFormControlTextarea1">Status</label>
                          <div class="form-check-size rtl-input">
                            <div class="form-check form-check-inline">
                              <input class="form-check-input me-2" id="inlineRadio1" type="radio" name="status"  <?php echo (isset($status) && $status == 'active') ? 'checked' : ''; ?> value="active" checked>
                              <label class="form-check-label" for="inlineRadio1">Active</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input me-2" id="inlineRadio2" type="radio" name="status"  <?php echo (isset($status) && $status == 'inactive') ? 'checked' : ''; ?> value="inactive">
                              <label class="form-check-label" for="inlineRadio2">Inactive</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input me-2" id="inlineRadio3" type="radio" name="status"  <?php echo (isset($status) && $status == 'suspend') ? 'checked' : ''; ?> value="suspend">
                              <label class="form-check-label" for="inlineRadio3">Suspend</label>
                            </div>
                          </div>
                       
                      </div>
                </div>
              
              </div>
              <?php
                                    if($_REQUEST["mode"] == "edit" ){
                               ?>
                               <div class="row mb-3">
                                   <div class="col-sm-6"></div>
                                   <div class="col-sm-6">
                                       <img src="<?php echo $profile_image; ?>" alt="Profile Photo" height="150px" width="150px" class="rounded-circle">
                                   </div>
                               </div>
                               <?php } ?>
              <div id="response" class="text-success"></div>
              <div class="card-footer text-center">
              <input type="hidden" name="hid" value="<?php echo $_REQUEST["mode"]?>">
              <input type="hidden" name="id" value="<?php echo $rows["id"]?>">
                <button class="btn btn-primary" type="submit">Submit</button>
                <button type="button" onclick="goBack()" class="btn btn-outline-primary">Cancel</button>
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
    <!-- sidebar -->
    <script src="assets/js/sidebar.js"></script>
    <!-- scrollbar-->
    <script src="assets/js/scrollbar/simplebar.js"></script>
    <script src="assets/js/scrollbar/custom.js"></script>
    <!-- slick-->
    <script src="assets/js/slick/slick.min.js"></script>
    <script src="assets/js/slick/slick.js"></script>
    <!-- datatable-->
    <script src="assets/js/datatable/datatables/jquery.dataTables.min.js"></script>
    <!-- page_datatable-->
    <script src="assets/js/js-datatables/datatables/datatable.custom.js"></script>
    <!-- page_datatable-->
    <script src="assets/js/datatable/datatables/datatable.custom.js"></script>
    <!-- theme_customizer-->
    <script src="assets/js/theme-customizer/customizer.js"></script>
    <!-- custom script -->
    <script src="assets/js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/password.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {
  // Initialize form validation
  $("#loginForm").validate({
    rules: {
      name: {
        required: true,
        minlength: 3,
        pattern: /^[A-Za-z\s]+$/  // Allow only letters and spaces
      },
      email: {
        required: true,
        email: true
      },
      mobile: {
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
      validity: {
        required: true
      },
      address: {
        required: true,
        minlength: 10
      },
      status: {
        required: true
      }
    },
    messages: {
      name: {
        required: "Please enter your name.",
        minlength: "Your name must be at least 3 characters long.",
        pattern: "Please enter a valid name (only letters and spaces allowed)."
      },
      email: {
        required: "Please enter your email.",
        email: "Please enter a valid email address."
      },
      mobile: {
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
      validity: {
        required: "Please choose a validity period."
      },
      address: {
        required: "Please enter your address.",
        minlength: "Your address must be at least 10 characters long."
      },
      status: {
        required: "Please select a status."
      }
    },
    errorElement: "span",  // Error messages will be inside <span> tags
    errorClass: "error-message",  // Assign class to the error message
    highlight: function(element) {
      $(element).addClass("is-invalid");  // Add class to highlight invalid fields
    },
    unhighlight: function(element) {
      $(element).removeClass("is-invalid");  // Remove class when field is valid
    }
  });
});

</script>
  </body>
</html>