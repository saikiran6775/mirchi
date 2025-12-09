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
    // Helper function to prepare and execute the query
    function executeQuery($sql, $params, $types = "s") {
        global $conn;
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, $types, ...$params);
            return mysqli_stmt_execute($stmt);
        }
        return false;
    }

    // Adding Mirchi Type
    if ($_REQUEST['hid'] == 'add') {
        $mirchi = $_POST['mirchi'];
        // Sanitize input
        $mirchi = mysqli_real_escape_string($conn, $mirchi);

        $sql = "INSERT INTO mirchi_types (mirchi_type) VALUES (?)";
        $params = [$mirchi];

        if (executeQuery($sql, $params)) {
            $_SESSION['success_message'] = "Data Inserted successfully";
            $_SESSION['flash_color'] = "#052c65";
        } else {
            $_SESSION['success_message'] = "Unable to Add Data";
            $_SESSION['flash_color'] = "red";
        }
    }

    // Edit Mirchi Type
    if ($_REQUEST['hid'] == 'edit') {
      $form_id = $_POST['id'];
      $mirchi = $_POST['mirchi'];
      // Sanitize input
      $mirchi = mysqli_real_escape_string($conn, $mirchi);
  
      // Check if ID exists
      $checkQuery = "SELECT * FROM mirchi_types WHERE id = ?";
      $stmt = mysqli_prepare($conn, $checkQuery);
      mysqli_stmt_bind_param($stmt, 'i', $form_id);
      mysqli_stmt_execute($stmt);
      $result = mysqli_stmt_get_result($stmt);
  
      if (mysqli_num_rows($result) == 0) {
          $_SESSION['success_message'] = "Record with ID $form_id not found";
          $_SESSION['flash_color'] = "red";
      } else {
          // Proceed with the update query if the record exists
          $sql = "UPDATE mirchi_types SET mirchi_type = ? WHERE id = ?";
          $params = [$mirchi, $form_id];
  
          if (executeQuery($sql, $params, 'si')) {
              $_SESSION['success_message'] = "Record updated successfully";
              $_SESSION['flash_color'] = "#052c65";
          } else {
              $_SESSION['success_message'] = "Error updating record: " . mysqli_error($conn);
              $_SESSION['flash_color'] = "red";
          }
      }
  }

    // Delete Mirchi Type (set status = 0)
    if ($_REQUEST['hid'] == 'delete') {
        $id_to_update = $_REQUEST['id'];
        $new_value = 0;  // Soft delete
        $sql = "UPDATE mirchi_types SET status = ? WHERE id = ?";
        $params = [$new_value, $id_to_update];

        if (executeQuery($sql, $params)) {
            $_SESSION['success_message'] = "Record Deleted successfully";
            $_SESSION['flash_color'] = "#052c65";
        } else {
            $_SESSION['success_message'] = "Unable to Delete Data";
            $_SESSION['flash_color'] = "red";
        }
    }
}

// Display success or error message in a modal window
if (isset($_SESSION['success_message']) && isset($_SESSION['flash_color'])) {
    echo '<div id="myModal" class="lightbox">
            <div class="modal-content">
                <span class="close-button" onclick="closeModal()">&times;</span>
                <p style="color: ' . $_SESSION['flash_color'] . '">' . $_SESSION['success_message'] . '</p>
            </div>
          </div>';

    // Clear the Success or Error message from the session
    unset($_SESSION['success_message']);
    
    // Redirect after 1 second
    echo '<script>
            setTimeout(function() {
                window.location.href = "manage-mirchi-type.php"; // Adjust the page URL if needed
            }, 1000);
          </script>';
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
      .error{
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
    .form-control{
    padding:2px;
    border-radius:0px;
   
    margin-bottom:10px;
     padding-left:15px;
      padding-right:10px;
      padding-top:2px;
      padding-bottom:2px;
   
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
                                        $sql = "SELECT * FROM `mirchi_types` WHERE `status` = '1'";
                                        $result = $conn->query($sql);
                                        $i = 0;
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $i++;
                                        ?>
                                        <tr>
                                            <td><?php echo $i;?></td>
                                            <td><?php echo $row["mirchi_type"]; ?></td>
                                            <td> 
                                                <ul class="action"> 
                                                    <li class="edit"> <a href="manage-mirchi-type.php?mode=edit&id=<?php echo $row['id'];?>"><i class="icon-pencil-alt"></i></a></li>
                                                    <li class="delete"><a href="manage-mirchi-type.php?mode=delete&id=<?php echo $row['id'];?>" onclick="return confirm('Are you sure you want to delete this record?');"><i class="icon-trash"></i></a></li>
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
                                            $sql = "select * from mirchi_types where id='".$_REQUEST['id']."'";
                                            $res = mysqli_query($conn,$sql);
                                            $rows = mysqli_fetch_array($res);
            
                                            $mirchi = $rows["mirchi_type"];
                                            
                                        }else{
                                            $mirchi = "";
                                           
                                            $rows["id"] = '';
                                        }
                                    ?>
                                   <div class="card-body">
                                      <div class="row mx-5">
                                            <!-- <div id="myModal" class="lightbox">
                                            <div class="modal-content">
                                                <span class="close-button" onclick="closeModal()">&times;</span>
                                                <p style="color: " id="modal-message"></p>
                                            </div>
                                        </div> -->
                                        <div class="col-sm-6 col-md-6">
        <div class="mb-3">
          <label class="form-label">Mirchi Variants</label>
          <input class="form-control" type="text"  name="mirchi" value="<?php echo $mirchi;?>"/>
        </div>
      </div>

                                           <!-- <div class="col-md-5">
                                        <div class="mb-3">
                                          <label class="form-label">Mirchi Type</label>
                                          <input class="form-control" type="text" name="mirchi" value="<?php echo $mirchi;?>"/>
                                        </div>
                                    </div> -->
                                    
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
      mirchi: {
        required: true,
        minlength:3 // Ensure at least 2 characters are entered
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
    $(document).ready(function() {
        // Show the lightbox-style modal window
        $(".lightbox").fadeIn();
        // Close the lightbox-style modal after 3 seconds (adjust the duration as needed)
        setTimeout(function() {
            closeModal();
        }, 1000);
    });

    function closeModal() {
        $(".lightbox").fadeOut();
    }
</script>
  </body>
</html>