<?php
//session start
session_start();
//database connection
include_once('db-connect.php');
// Check if the user is logged in by verifying session variables
if (!isset($_SESSION['user_id'])) {
  // If user is not logged in, redirect to login page
  header('Location: marchant-login.php');
  exit(); // Stop further execution
}
if (!empty($_REQUEST['hid'])) {
  $message = ""; // Variable to store message
  $status = "";  // Variable to store success/error status

  // Edit Mirchi Type
  if ($_REQUEST['hid'] == 'edit') {
      
      // Sanitize input
      $gunny = mysqli_real_escape_string($conn, $_REQUEST['gunny']);
      $id = intval($_REQUEST["id"]); // Convert ID to integer to prevent SQL injection

      // Prepared statement to update Gunny Bag cost
      $sql = "UPDATE gunny_bag SET gunny_bag = ? WHERE id = ?";

      if ($stmt = mysqli_prepare($conn, $sql)) {
          // Bind the parameters
          mysqli_stmt_bind_param($stmt, "si", $gunny, $id); // 's' for string, 'i' for integer
          
          // Execute the statement
          if (mysqli_stmt_execute($stmt)) {
              $_SESSION['message'] = "Gunny Bag Cost updated successfully!";
              $_SESSION['status'] = "success";
          } else {
              $_SESSION['message'] = "Failed to update Gunny Bag Cost. Error: " . mysqli_error($conn);
              $_SESSION['status'] = "error";
          }
          // Close statement
          mysqli_stmt_close($stmt);
      } else {
          $_SESSION['message'] = "Failed to prepare the SQL statement. Error: " . mysqli_error($conn);
          $_SESSION['status'] = "error";
      }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Admiro admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Admiro admin template, best javascript admin, dashboard template, bootstrap admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <title>Admiro - Premium Admin Template</title>
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
    .form-control{
    padding:2px;
    border-radius:0px;
   
    margin-bottom:10px;
     padding-left:15px;
      padding-right:10px;
      padding-top:2px;
      padding-bottom:2px;
   
  }
  .form-label {
      margin-bottom:2px;
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
  <?php if (!empty($_SESSION['message'])): ?>
          <!-- Bootstrap Modal for Messages -->
          <div class="modal fade show" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel"
            aria-hidden="true" style="display: block;">
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
          <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-sm-6 col-12"> 
                  <h2>Manage Gunny Bag Price</h2>
                </div>
                <div class="col-sm-6 col-12">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index-m.php"><i class="iconly-Home icli svg-color"></i></a></li>
                    <li class="breadcrumb-item active">Gunny Bag Price</li>
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
                              <table class="display" id="basic-1">
                                <thead>
                                <tr>
                                    <th>Sl.No</th>
                                    <th>Gunny Bag Price</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                        $sql = "SELECT * FROM `gunny_bag` WHERE `status` = '1'";
                                        $result = $conn->query($sql);
                                        $i = 0;
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $i++;
                                        ?>
                                        <tr>
                                            <td><?php echo $i;?></td>
                                            <td><?php echo $row["gunny_bag"]; ?></td>
                                            <td> 
                                                <ul class="action"> 
                                                    <li class="edit"> <a href="gunny-bag-cost.php?mode=edit&id=<?php echo $row['id'];?>"><i class="icon-pencil-alt"></i></a></li>
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
                                  }else{
                                ?>
                           <div class="row">
                                <form class="card" id="loginForm" enctype="multipart/form-data" method="post">
                                    <?php
                                          if($_REQUEST["mode"] == "edit" ){
                                            $sql = "select * from gunny_bag where id='".$_REQUEST['id']."'";
                                            $res = mysqli_query($conn,$sql);
                                            $rows = mysqli_fetch_array($res);
            
                                            $gunny = $rows["gunny_bag"];
                                            
                                        }
                                    ?>
                                   <div class="card-body">
                                      <div class="row mx-5">
                                      <div class="col-sm-3 col-md-3"></div>
                                        <div class="col-sm-6 col-md-6">
                               <div class="mb-3">
                                 <label class="form-label">Cost of Gunny Bag</label>
                                   <input class="form-control" type="number"  name="gunny" value="<?php echo $gunny;?>"/>
                                  </div>
                                 </div> 
                                 <div class="col-sm-3 col-md-3"></div>  
                                   <div class="card-footer text-center">
                                      <input type="hidden" name="hid" value="<?php echo $_REQUEST["mode"]?>">
                                      <input type="hidden" name="id" value="<?php echo $rows["id"]?>">
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
      gunny: {
        required: true,
        minlength:2 // Ensure at least 2 characters are entered
      }
    },
    messages: {
      // Custom messages for each field
      gunny: {
        required: "Please enter the cost.",
        minlength: "Enter cost at least 2 digits long."
      }
    },
    submitHandler: function (form) {
      form.submit(); // Submit the form if validation passes
    }
  });
});

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
          window.location.href = "gunny-bag-cost.php";
        }
      }, 1000);

      // Close Modal and Redirect Immediately on Button Click
      document.getElementById("closeModal").addEventListener("click", function () {
        clearInterval(interval);
        window.location.href = "gunny-bag-cost.php";
      });
    });

    // Checking Mirchi Varient is Avaliable or not?
    //*********************************** */
    $(document).ready(function () {
      $("input[name='batch']").on("keyup", function () {
        let batch = $(this).val().trim();
        let id = $("input[name='id']").val(); // ID (for edit mode)
        let mode = $("input[name='hid']").val(); // Check add/edit mode

        if (batch.length >= 3) {
          $.ajax({
            url: "check-pvt-mark-exists.php",
            type: "POST",
            data: { batch: batch, id: id, mode: mode },
            success: function (response) {
              response = response.trim();
              console.log("Server Response:", response); // Debugging

              if (response === "exists") {
                $("#mirchi-error").text("This Mirchi Variant already exists!").css("color", "red");
                $("button[type='submit']").prop("disabled", true); // Disable button
              } else if (response === "available") {
                $("#mirchi-error").text("This Mirchi Variant is available!").css("color", "green");
                $("button[type='submit']").prop("disabled", false);
              } else {
                console.warn("Unexpected Response:", response);
              }
            },
            error: function (jqXHR, textStatus, errorThrown) {
              console.error("AJAX Error:", textStatus, errorThrown);
            }
          });
        } else {
          $("#mirchi-error").text(""); // Remove error when input is short
          $("button[type='submit']").prop("disabled", false);
        }
      });
    });

    function goBack() {
      window.history.back();
    }

</script>
  </body>
</html>