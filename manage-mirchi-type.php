<?php
session_start(); // Start the session to store success/error messages
include_once('db-connect.php'); // Include the database connection

// Check if a form action is submitted
if (!empty($_REQUEST['hid'])) {
  $message = ""; // Variable to store message
  $status = "";  // Variable to store success/error status

  // **Add New Record**
  if ($_REQUEST['hid'] == 'add') {
    $mirchi = mysqli_real_escape_string($conn, $_REQUEST['mirchi']); // Prevent SQL Injection
    $sql = "INSERT INTO mirchi_types (mirchi_type) VALUES ('$mirchi')"; // Insert query

    // Execute query and store the result
    if (mysqli_query($conn, $sql)) {
      $_SESSION['message'] = "Mirchi Variant added successfully!";
      $_SESSION['status'] = "success"; // Store success status
    } else {
      $_SESSION['message'] = "Failed to add mirchi variant.";
      $_SESSION['status'] = "error"; // Store error status
    }
  }

  // **Edit Existing Record**
  if ($_REQUEST['hid'] == 'edit') {
    $mirchi = mysqli_real_escape_string($conn, $_REQUEST['mirchi']);
    $id = intval($_REQUEST["id"]); // Convert ID to integer to prevent SQL injection
    $sql = "UPDATE mirchi_types SET mirchi_type='$mirchi' WHERE id='$id'";

    // Execute update query
    if (mysqli_query($conn, $sql)) {
      $_SESSION['message'] = "Mirchi Variant updated successfully!";
      $_SESSION['status'] = "success";
    } else {
      $_SESSION['message'] = "Failed to update mirchi variant.";
      $_SESSION['status'] = "error";
    }
  }

  // **Soft Delete (Update Status to 0)**
  if ($_REQUEST['hid'] == 'delete') {
    $id = intval($_REQUEST["id"]); // Convert ID to integer
    $sql = "UPDATE mirchi_types SET status=0 WHERE id='$id'";

    // Execute update query
    if (mysqli_query($conn, $sql)) {
      $_SESSION['message'] = "Mirchi Variant deactivated successfully!";
      $_SESSION['status'] = "success";
    } else {
      $_SESSION['message'] = "Failed to deactivate mirchi variant.";
      $_SESSION['status'] = "error";
    }
  }

  // Redirect back to the manage page after processing
  header('Location: manage-mirchi-type.php');
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
                <h2>Manage Mirchi Variants</h2>
              </div>
              <div class="col-sm-6 col-12">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index-m.php"><i class="iconly-Home icli svg-color"></i></a></li>
                  <li class="breadcrumb-item active">Mirchi variants</li>
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
                          onclick="location.href='manage-mirchi-type.php?mode=add'">
                          <i class="icon-plus"></i> Add Mirchi Type
                        </button>
                      </div>

                      <table class="display" id="basic-1">
                        <thead>
                          <tr>
                            <th>Sl.No</th>
                            <th>Mirchi variants</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $sql = "SELECT * FROM `mirchi_types` WHERE `status` = '1' ORDER BY `id` DESC";
                          $result = $conn->query($sql);
                          $i = 0;
                          if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                              $i++;
                              ?>
                              <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $row["mirchi_type"]; ?></td>
                                <td>
                                  <ul class="action">
                                    <li class="edit"> <a href="manage-mirchi-type.php?mode=edit&id=<?php echo $row['id']; ?>">
                                        <i class="icon-pencil-alt"></i></a>
                                    </li>
                                    <li class="delete"><a
                                        href="manage-mirchi-type.php?hid=delete&id=<?php echo $row['id']; ?>"
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
                      $sql = "select * from mirchi_types where id='" . $_REQUEST['id'] . "'";
                      $res = mysqli_query($conn, $sql);
                      $rows = mysqli_fetch_array($res);
                      $mirchi = $rows["mirchi_type"];
                    } else {
                      $mirchi = "";
                      $rows["id"] = '';
                    }
                    ?>
                    <!-- close more-edit -->
                    <div class="row">
                      <form class="card" id="loginForm" enctype="multipart/form-data" method="post">
                        <div class="card-body ">
                          <div class="row mx-5">
                            <div class="col-sm-3 col-md-3"></div>
                            <div class="col-sm-6 col-md-6">
                              <div class="mb-3 ">
                                <label class="form-label">Mirchi Variants</label>
                                <input class="form-control" type="text" name="mirchi" value="<?php echo $mirchi; ?>"/>
                                <small id="mirchi-error"></small>
                              </div>
                            </div>
                            <div class="col-sm-3 col-md-3"></div>
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
          mirchi: {
            required: true,
            minlength: 3 // Ensure at least 2 characters are entered
          }
        },
        messages: {
          // Custom messages for each field
          mirchi: {
            required: "Please enter the mirchi name.",
            minlength: "The mirchi name must be at least 3 characters long."
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
          window.location.href = "manage-mirchi-type.php";
        }
      }, 1000);

      // Close Modal and Redirect Immediately on Button Click
      document.getElementById("closeModal").addEventListener("click", function () {
        clearInterval(interval);
        window.location.href = "manage-mirchi-type.php";
      });
    });

    // Checking Mirchi Varient is Avaliable or not?
    //*********************************** */
    $(document).ready(function () {
      $("input[name='mirchi']").on("keyup", function () {
        let mirchiValue = $(this).val().trim();
        let id = $("input[name='id']").val(); // Get the ID if editing
        let mode = $("input[name='hid']").val(); // Check if add or edit

        if (mirchiValue.length >= 3) {
          $.ajax({
            url: "check-mirchi-exists.php",
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