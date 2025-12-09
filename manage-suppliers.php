<?php
// Start the session to track user data across pages
session_start();

// Store the current page URL in session to track last visited page
$_SESSION['last_page'] = $_SERVER['REQUEST_URI'];

// Include the database connection file
include_once('db-connect.php');

// Check if the user is logged in by verifying session variables
if (!isset($_SESSION['user_id'])) {
    // If user is not logged in, redirect to login page
    header('Location: marchant-login.php');
    exit(); // Stop further execution
}

// Check if a form action is submitted
if (!empty($_REQUEST['hid'])) {
  $message = ""; // Variable to store message
  $status = "";  // Variable to store success/error status

  // **Add New Record**
  if ($_REQUEST['hid'] == 'add') {
    $supplier = $_POST['supplier'];
    $shopname = $_POST['shopname'];
    $mobile = $_POST['mobile'];
    $address = $_POST['address'];
    $gst= $_POST['gst'];
    $adhar=$_POST['adhar'];
    $account=$_POST['account'];
    if($_SESSION['user_id']== $_SESSION['merchant_id']){
      $user_id=$_SESSION['user_id'];
      }else {
        $user_id=$_SESSION['merchant_id'];
      }
    // Prepare the SQL query
    $sql = "INSERT INTO suppliers (supplier, shopname, mobile, address, gst, adhar,account,user_id) VALUES (?, ?, ?, ?, ?, ?, ?,?)";
    $result = mysqli_prepare($conn, $sql);
    if ($result) {
        mysqli_stmt_bind_param($result, "ssssssss", $supplier, $shopname, $mobile, $address,$gst,$adhar,$account,$user_id);
        mysqli_stmt_execute($result);
      $_SESSION['message'] = "Supplier added successfully!";
      $_SESSION['status'] = "success"; // Store success status
    } else {
      $_SESSION['message'] = "Failed to add Supplier.";
      $_SESSION['status'] = "error"; // Store error status
    }
  }

  // **Edit Existing Record**
  if ($_REQUEST['hid'] == 'edit') {
    $form_id = $_POST['id'];
    $supplier = $_POST['supplier'];
    $shopname = $_POST['shopname'];
    $mobile = $_POST['mobile'];
    $address = $_POST['address'];
    $gst= $_POST['gst'];
    $adhar=$_POST['adhar'];
    $account=$_POST['account'];

    // Prepare SQL for updating supplier details
    $sql = "UPDATE suppliers SET supplier = ?, shopname = ?, mobile = ?, address = ?, gst = ?, adhar = ?, account = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssssss", $supplier, $shopname, $mobile, $address, $gst, $adhar, $account, $form_id);
        mysqli_stmt_execute($stmt);
      $_SESSION['message'] = "Supplier updated successfully!";
      $_SESSION['status'] = "success";
    } else {
      $_SESSION['message'] = "Failed to update Supplier.";
      $_SESSION['status'] = "error";
    }
  }

  // **Soft Delete (Update Status to 0)**
  if ($_REQUEST['hid'] == 'delete') {
    $id = intval($_REQUEST["id"]); // Convert ID to integer
    $sql = "UPDATE suppliers SET status=0 WHERE id='$id'";

    // Execute update query
    if (mysqli_query($conn, $sql)) {
      $_SESSION['message'] = "Supplier deactivated successfully!";
      $_SESSION['status'] = "success";
    } else {
      $_SESSION['message'] = "Failed to deactivate Supplier.";
      $_SESSION['status'] = "error";
    }
  }

  // Redirect back to the manage page after processing
  header('Location: manage-suppliers.php');
  exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Mirchi CRM Admin Panel" />
  <meta name="keywords" content="Mirchi CRM Admin Panel" />
  <meta name="author" content="Mirchi CRM" />
  <title>Mirchi CRM - Premium Admin Template</title>
  <!-- Favicon icon-->
  <link rel="icon" href="assets/images/favicon.png" type="image/x-icon">
  <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon">
  <!-- Google font-->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
  <link
    href="https://fonts.googleapis.com/css2?family=Nunito+Sans:opsz,wght@6..12,200;6..12,300;6..12,400;6..12,500;6..12,600;6..12,700;6..12,800;6..12,900;6..12,1000&amp;display=swap"
    rel="stylesheet">
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
    .form-control {
     padding-left:15px;
     padding-top:0px;
     padding-bottom:0px;
     border-radius:0px;
    }
    .form-label{
      margin-bottom:2px;
    }
    .error{
        color:red;
    }
  </style>
</head>

<body>
  <!-- Pop Window Begins-->
  <?php if (!empty($_SESSION['message'])): ?>
    <!-- Bootstrap Modal for Messages -->
    <div class="modal fade show" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true"
      style="display: block;">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <!-- Header with Light Background -->
          <div class="modal-header">
            <h5 class="modal-title" id="messageModalLabel">
              <?php echo ($_SESSION['status'] == 'success') ? '✅ Success' : '❌ Error'; ?>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>

          <!-- Modal Body -->
          <div class="modal-body text-center">
            <p style="font-size: 16px; font-weight: 500;"><?php echo $_SESSION['message']; ?></p>
            <p class="countdown">Redirecting in <span id="countdown">3</span> seconds...</p>
          </div>

          <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-primary px-4" id="closeModal">OK</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Clear Session Messages -->
    <?php unset($_SESSION['message']);
    unset($_SESSION['status']); ?>
  <?php endif; ?>
  <!-- End Popup Window -->
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
              <div class="col-sm-6 col-12">
                <h2>Manage Supplier</h2>
              </div>
              <div class="col-sm-6 col-12">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index-m.php"><i class="iconly-Home icli svg-color"></i></a></li>
                  <li class="breadcrumb-item active">Manage Supplier</li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-12">
              <div class="card">
                <div class="card-body">

                  
                <?php
                                if (empty($_REQUEST['mode'])) {
                                ?>
                               <div class="table-responsive">
                                     <div class="mb-5">
                                            <button type="button" class="btn btn-success btn-icon-text " style="float:left"
                                                onclick="location.href='manage-suppliers.php?mode=add'">
                                                <i class="icon-plus"></i> Add Supplier
                                            </button>
                                        </div>
                                
                              <table class="display" id="basic-1">
                                <thead>
                                <tr>
                                    <th>Sl.No</th>
                                    <th>Supplier</th>
                                    <th>Shop Name</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Bank AC Number</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                // Get the correct user ID (either user_id or merchant_id)
                                 if ($_SESSION['user_id'] == $_SESSION['merchant_id']) {
                                  $user_id = $_SESSION['user_id'];
                                   } else {
                                  $user_id = $_SESSION['merchant_id'];
                                    }
                               // SQL query to get suppliers with status = '1' and filter by user_id
                                   $sql = "SELECT * FROM `suppliers` WHERE `status` = '1' AND `user_id` = '$user_id'";
                                        $result = $conn->query($sql);
                                        $i = 0;
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $i++;
                                        ?>
                                        <tr>
                                            <td><?php echo $i;?></td>
                                            <td><?php echo $row["supplier"]; ?></td>
                                            <td><?php echo $row["shopname"]; ?></td>
                                            <td><?php echo $row["mobile"]; ?></td>
                                            <td><?php echo $row["address"]; ?></td>
                                            <td><?php echo $row["account"]; ?></td>
                                            <td> 
                                            <ul class="action">
                                    <li class="edit"> <a href="manage-suppliers.php?mode=edit&id=<?php echo $row['id']; ?>">
                                        <i class="icon-pencil-alt"></i></a>
                                    </li>
                                    <li class="delete"><a
                                        href="manage-suppliers.php?hid=delete&id=<?php echo $row['id']; ?>"
                                        onclick="return confirm('Are you sure you want to delete this record?');">
                                        <i class="icon-trash"></i></a>
                                    </li>

                                  </ul>
                                            </td>
                                        </tr>
                                        <?php 
                                            }
                                        }
                               
                                        ?>
                                </tbody>
                              </table>
                            </div>
                             <?php
                  } else {
                    ?>
                    <!-- start mode-edit -->
                    <?php
                    
                    if ($_REQUEST["mode"] == "edit") {
                      $sql = "SELECT * FROM suppliers WHERE id='" . $_REQUEST['id'] . "'";
                      $res = mysqli_query($conn, $sql);
                      $rows = mysqli_fetch_array($res);
                  
                      $supplier = $rows["supplier"];
                      $shopname = $rows["shopname"];
                      $mobile = $rows["mobile"];
                      $address = $rows["address"];
                      $gst = $rows["gst"];
                      $adhar = $rows["adhar"];
                      $account = $rows["account"];
                    } else {
                      $supplier = "";
                      $shopname = "";
                      $mobile = "";
                      $address = "";
                      $rows["id"] = '';
                      $gst = "";
                      $adhar = "";
                      $account = "";
                    }
                   
                    ?>
                    <!-- close more-edit -->
                    <div class="row">
                    <form class="card" id="loginForm" enctype="multipart/form-data" method="post">
  <div class="card-body">
    <div class="row mx-5">
      <!-- Supplier Name -->
      <div class="col-sm-6 col-md-6">
        <div>
          <label class="form-label ">Supplier Name</label>
          <input class="form-control" type="text" name="supplier" value="<?php echo $supplier; ?>"/>
        </div>
      </div>

      <!-- Shop Name -->
      <div class="col-sm-6 col-md-6">
        <div>
          <label class="form-label">Shop Name</label>
          <input class="form-control" type="text" name="shopname" value="<?php echo $shopname; ?>"/>
        </div>
      </div>

      <!-- Phone -->
      <div class="col-sm-6 col-md-6">
        <div>
          <label class="form-label">Phone</label>
          <input class="form-control" type="text" name="mobile" value="<?php echo $mobile; ?>"/>
        </div>
      </div>
      <!-- GST -->
      <div class="col-sm-6 col-md-6">
        <div>
          <label class="form-label w-25">GST</label>
          <input class="form-control" type="text" name="gst" value="<?php echo $gst; ?>"/>
        </div>
      </div>

      <!-- Adharcard Number -->
      <div class="col-sm-6 col-md-6">
        <div>
          <label class="form-label">Adharcard Number</label>
          <input class="form-control" type="text" name="adhar" value="<?php echo $adhar; ?>"/>
        </div>
      </div>
      

      <!-- Bank Account Number -->
      <div class="col-sm-6 col-md-6">
        <div>
          <label class="form-label">Bank Account Number</label>
          <input class="form-control" type="text" name="account" value="<?php echo $account; ?>"/>
        </div>
      </div>
        <!-- Address -->
      <div class="col-sm-6 col-md-6">
        <div>
          <label class="form-label" for="exampleFormControlTextarea1">Address</label>
          <textarea class="form-control" id="exampleFormControlTextarea1" rows="2" style="height:40px;" name="address"><?php echo $address; ?></textarea>
        </div>
      </div>
    </div>
  </div>


  <div class="card-footer text-center">
    <input type="hidden" name="hid" value="<?php echo $_REQUEST["mode"] ?>">
    <input type="hidden" name="id" value="<?php echo $rows["id"] ?>">
    <button class="btn btn-primary" type="submit">Submit</button>
    <button type="button" onclick="goBack()" class="btn btn-outline-primary">Cancel</button>
  </div>
</form>
                      <?php
                  }
                  ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Container-fluid Ends-->
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
$(document).ready(function () {
    // Initialize form validation
    $("form").validate({
      rules: {
        // Validation rules for each input
        supplier: {
          required: true,
          minlength: 2 // Ensure at least 2 characters are entered
        },
        shopname: {
          required: true,
          minlength: 2 // Ensure at least 2 characters are entered
        },
        mobile: {
          required: true,
          digits: true, // Allow only numbers
          minlength: 10, // Minimum 10 digits (assuming phone number is a 10-digit number)
          maxlength: 10 // Maximum of 10 digits
        },
        address: {
          required: true,
          minlength: 10 // Ensure at least 10 characters for the address
        },
        adhar: {
          required: true,
          digits: true, // Allow only numeric input
          minlength: 12, // Minimum 12 digits for Adhar number
          maxlength: 12 // Maximum 12 digits for Adhar number
        },
        account: {
          required: true,
          digits: true, // Allow only numeric input
          minlength: 10, // Minimum 10 digits for Bank account number
          maxlength: 18 // Maximum 18 digits for Bank account number
        }
      },
      messages: {
        // Custom messages for each field
        supplier: {
          required: "Please enter the supplier name.",
          minlength: "The supplier name must be at least 2 characters long."
        },
        shopname: {
          required: "Please enter the shop name.",
          minlength: "The shop name must be at least 2 characters long."
        },
        mobile: {
          required: "Please enter the phone number.",
          digits: "Please enter a valid phone number.",
          minlength: "The phone number must be at least 10 digits long.",
          maxlength: "The phone number must be no more than 10 digits long."
        },
        address: {
          required: "Please enter the address.",
          minlength: "The address must be at least 10 characters long."
        },
        adhar: {
          required: "Please enter Adhar Number",
          digits: "Adhar number should contain only digits.",
          minlength: "Adhar number must be exactly 12 digits long.",
          maxlength: "Adhar number must be exactly 12 digits long."
        },
        account: {
          required: "Please enter your Bank account number",
          digits: "Bank account number should contain only digits.",
          minlength: "Bank account number must be at least 10 digits long.",
          maxlength: "Bank account number must be no more than 18 digits long."
        }
      },
      submitHandler: function (form) {
        form.submit(); // Submit the form if validation passes
      }
    });
  });
  function goBack() {
        window.history.back();
    }
    // Popup Widnow *********************
    // *******************************
    document.addEventListener("DOMContentLoaded", function () {
      var myModal = new bootstrap.Modal(document.getElementById('messageModal'));
      myModal.show(); // Show modal when page loads

      // Countdown Timer for Auto-Redirect
      let timeLeft = 3;
      const countdown = document.getElementById("countdown");

      const interval = setInterval(function () {
        timeLeft--;
        countdown.innerText = timeLeft;
        if (timeLeft <= 0) {
          clearInterval(interval);
          window.location.href = "manage-suppliers.php";
        }
      }, 1000);

      // Close Modal and Redirect Immediately on Button Click
      document.getElementById("closeModal").addEventListener("click", function () {
        clearInterval(interval);
        window.location.href = "manage-suppliers.php";
      });
    });

    // Checking Mirchi Varient is Avaliable or not?
    //*********************************** */
    $(document).ready(function () {
      $("input[name='supplier']").on("keyup", function () {
        let mirchiValue = $(this).val().trim();
        let id = $("input[name='id']").val(); // Get the ID if editing
        let mode = $("input[name='hid']").val(); // Check if add or edit

        if (mirchiValue.length >= 3) {
          $.ajax({
            url: "check-mirchi-existss.php",
            type: "POST",
            data: { mirchi: mirchiValue, id: id, mode: mode },
            success: function (response) {
              if (response == "exists") {
                $("#mirchi-error").text("This Mirchi Variant already exists!").css("color", "red");
                $("button[type='submit']").prop("disabled", true); // Disable submit button
              } else {
                $("#mirchi-error").text(""); // Remove error
                $("button[type='submit']").prop("disabled", false);
              }
            },
          });
        }
      });
    });

  </script>
</body>

</html>