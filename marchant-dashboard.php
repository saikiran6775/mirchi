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
      .small-card{
        width:auto;
        height:150px;
        background-color:red;
      }
      .card-text{
        font-size:25px;
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
       <div class="page-body">
          <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-sm-6 col-12">
                  <h2>Dashboard</h2>
                </div>
                <div class="col-sm-6 col-12">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html"><i class="iconly-Home icli svg-color"></i></a></li>
                    <li class="breadcrumb-item">Login</li>
                    <li class="breadcrumb-item active">Dashboard</li>
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
  <div class="row g-4"> <!-- g-4 adds gap between cards -->
    
    <!-- Card 1 -->
    <?php if ($_SESSION['role'] == 'admin') { ?>
    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
      <a href="manage-employees.php">
        <div class="card bg-primary small-card">
          <div class="card-body">
            <h2 class="card-title text-center">Manage Employees</h2>
            <p class="card-text text-center"><i class="fa-solid fa-users"></i></p>
          </div>
        </div>
      </a>
    </div><?php }?>
    <?php if ($_SESSION['purpose'] == 'export') { ?>
    <!-- Card 2 -->
    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
      <a href="weight-calculation.php">
        <div class="card bg-primary small-card">
          <div class="card-body">
            <h2 class="card-title text-center">Weight Calculation</h2>
            <p class="card-text text-center"><i class="fa-solid fa-scale-balanced"></i></p>
          </div>
        </div>
      </a>
    </div>
    <!-- Card 4 -->
    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
      <a href="manage-supplier.php">
        <div class="card bg-primary small-card">
          <div class="card-body">
            <h2 class="card-title text-center">Manage Suppliers</h2>
            <p class="card-text text-center"><i class="fa-solid fa-people-arrows"></i></p>
          </div>
        </div>
      </a>
    </div>
    
    <!-- Card 6 -->
    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
      <a href="gunny-bag-cost.php">
        <div class="card bg-primary small-card">
          <div class="card-body">
            <h2 class="card-title text-center">Manage Gunny Bag Cost</h2>
            <p class="card-text text-center"><i class="fa-solid fa-sack-dollar"></i></p>
          </div>
        </div>
      </a>
    </div>
    
    <!-- Card 7 -->
    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
      <a href="weight-report.php">
        <div class="card bg-primary small-card">
          <div class="card-body">
            <h2 class="card-title text-center">Weight Calculation Report</h2>
            <p class="card-text text-center"><i class="fa-regular fa-newspaper"></i></p>
          </div>
        </div>
      </a>
    </div>
  <?php } ?>
  <?php if ($_SESSION['purpose'] == 'import') { ?>
   <div class="col-12 col-sm-6 col-md-4 col-lg-3">
      <a href="manage-seller.php">
        <div class="card bg-primary small-card">
          <div class="card-body">
            <h2 class="card-title text-center">Weight Calculation</h2>
            <p class="card-text text-center"><i class="fa-regular fa-newspaper"></i></p>
          </div>
        </div>
      </a>
    </div>
     <div class="col-12 col-sm-6 col-md-4 col-lg-3">
      <a href="stock-details.php">
        <div class="card bg-primary small-card">
          <div class="card-body">
            <h2 class="card-title text-center">Manage Stock Details</h2>
            <p class="card-text text-center"><i class="fa-solid fa-cubes-stacked"></i></p>
          </div>
        </div>
      </a>
    </div>
     <div class="col-12 col-sm-6 col-md-4 col-lg-3">
      <a href="gunny-bag-cost.php">
        <div class="card bg-primary small-card">
          <div class="card-body">
            <h2 class="card-title text-center">Manage Gunny Bag Cost</h2>
            <p class="card-text text-center"><i class="fa-solid fa-sack-dollar"></i></p>
          </div>
        </div>
      </a>
    </div>
  <?php }?>
  
  </div>
</div>
              </div>
            </div>
            </div>
          
          <!-- Container-fluid Ends-->
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
  </body>
</html>