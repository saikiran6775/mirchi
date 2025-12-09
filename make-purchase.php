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
  .form-select{
   
     margin-bottom:10px;
      padding-left:15px;
      padding-right:10px;
      padding-top:2px;
      padding-bottom:2px;
       border-radius:0px;
    
  }
  .form-label {
      margin-bottom:0px;
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
                      <h2>Make Purchase
                      </h2>
                      <p class="mb-0 text-title-gray">Welcome back! Let’s start from where you left.</p>
                    </div>
                    <div class="col-sm-6 col-12">
                      <ol class="breadcrumb">
                        <li class="breadcrumb-item text-bold"><a href="index-m.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">
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
  <div class="card-header card-no-border pb-0">
    <div class="card-options">
      <a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
      <a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a> 
    </div>
  </div>

  <div class="card-body">
    <div class="row mx-4">
    <div class="col-sm-6 col-md-6">
        <div class="form-group">
        <label class="form-label">Date of Purchase</label>
        <input type="text" class="form-control" id="date" name="date" value="<?php echo date('Y-m-d'); ?>" readonly>
        </div>
      </div>
      
      <!-- Form Group with label and input side by side -->
      <div class="col-sm-6 col-md-6">
  <div class="form-group">
    <label class="form-label">Name of the Supplier </label>
    <?php 
    // SQL query to fetch supplier names from the 'suppliers' table
    $sql = "SELECT * FROM suppliers";
    $result = mysqli_query($conn, $sql); // Assume $conn is your database connection

    // Check if there are any suppliers in the database
    if (mysqli_num_rows($result) > 0) {
      // Open the select element
      echo '<select class="form-select" id="supplier" name="supplier" required> <option value="">Select supplier </option>';
      
      // Loop through the suppliers and create an option for each
      while ($row = mysqli_fetch_assoc($result)) {
        echo '<option value="' . $row['id'] . '">' . $row['supplier'] . '</option>';
      }

      // Close the select element
      echo '</select>';
    } else {
      // If no suppliers are found
      echo '<p>No suppliers found</p>';
    }
    ?>
  </div>
</div>

<div class="col-sm-6 col-md-6">
  <div class="form-group">
    <label class="form-label">Mirch Variant</label>
    <?php 
    // SQL query to fetch mirchi types from the 'mirchi_types' table
    $sql = "SELECT * FROM mirchi_types";
    $result = mysqli_query($conn, $sql); // Assume $conn is your database connection

    // Check if there are any mirchi types in the database
    if (mysqli_num_rows($result) > 0) {
      // Open the select element
      echo '<select class="form-select" id="mirchi_type" name="mirchi_type"><option value="">Select Mirchi Varient </option>';
      
      // Loop through the mirchi types and create an option for each
      while ($row = mysqli_fetch_assoc($result)) {
        echo '<option value="' . $row['mirchi_type'] . '">' . $row['mirchi_type'] . '</option>';
      }

      // Close the select element
      echo '</select>';
    } else {
      // If no mirchi types are found
      echo '<p>No mirchi types found</p>';
    }
    ?>
  </div>
</div>


<div class="col-sm-6 col-md-6">
  <div class="form-group">
    <label class="form-label">PVT.Mark</label>
    <?php 
    // SQL query to fetch bag batches from the 'bag_batch' table
    $sql = "SELECT * FROM bag_batch";
    $result = mysqli_query($conn, $sql); // Assume $conn is your database connection

    // Check if there are any bag batches in the database
    if (mysqli_num_rows($result) > 0) {
      // Open the select element
      echo '<select class="form-select" id="bag_batch" name="bag_batch"><option value="">Select PVT.Mark</option>';
      
      // Loop through the bag batches and create an option for each
      while ($row = mysqli_fetch_assoc($result)) {
        echo '<option value="' . $row['batch'] . '">' . $row['batch'] . '</option>';
      }

      // Close the select element
      echo '</select>';
    } else {
      // If no bag batches are found
      echo '<p>No bag batches found</p>';
    }
    ?>
  </div>
</div>

      <div class="col-sm-6 col-md-6">
        <div class="form-group">
          <label class="form-label">No Of Gunny Bags</label>
          <input type="number" class="form-control" id="no_of_bags" name="no_of_bags" required>
        </div>
      </div>
      <div class="col-sm-6 col-md-6">
  <div class="form-group">
    <label class="form-label">Gunny Bag Cost (each)</label>
    <?php
      // Execute SQL query to get the gunny bag rate
      $sql = "SELECT * FROM gunny_bag";  // Corrected SQL query (removed single quotes around table name)
      $result = mysqli_query($conn, $sql);

      // Check if there's a result and fetch the value
      if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $gunny_bag_rate = $row['gunny_bag'];  // Assuming the column holding the price is named 'rate'
      } else {
        $gunny_bag_rate = "";  // Set a default value in case there's no result
      }
    ?>
    <input type="number" class="form-control" id="gunnies_bag_rate" name="gunnies_bag_rate" value="<?php echo $gunny_bag_rate; ?>" readonly>
  </div>
</div>

      <div class="col-sm-6 col-md-6">
        <div class="form-group">
          <label class="form-label"> Total Gunny Bags Amount</label>
          <input type="number" class="form-control" id="gunnies_bag_total" name="gunnies_bag_total" readonly>
        </div>
      </div>
      <div class="col-sm-6 col-md-6">
        <div class="form-group">
          <label class="form-label">Mirchi Quinta Rate</label>
          <input type="number" class="form-control" id="qwinta_rate" name="qwinta_rate" required>
        </div>
      </div>
      <div class="col-sm-6 col-md-6">
        <div class="form-group">
          <label class="form-label">Gross Weight</label>
          <input type="text" class="form-control" id="grosswt" name="grosswt" readonly>
        </div>
      </div>
      <div class="col-sm-6 col-md-6">
        <div class="form-group">
          <label class="form-label">Net Weight</label>
          <input type="number" class="form-control" id="net_weight" name="net_weight" readonly>
        </div>
      </div>

      <div class="col-sm-6 col-md-6">
        <div class="form-group">
          <label class="form-label">Gross Amount</label>
          <input type="number" class="form-control" id="grass_amount" name="grass_amount" readonly>
        </div>
      </div>
     
      <div class="col-sm-6 col-md-6">
        <div class="form-group">
          <label class="form-label">Net Amount</label>
          <input type="number" class="form-control" id="net_amount" name="net_amount" readonly>
        </div>
      </div>

      <div class="col-sm-6 col-md-6">
        <div class="form-group">
          <label class="form-label">Upload Doc (if any)</label>
          <input type="file" class="form-control" id="doc" name="doc">
        </div>
      </div>

      <div class="col-sm-6 col-md-6">
        <div class="form-group">
          <label class="form-label">Notes (if any)</label>
          <textarea class="form-control" id="notes" name="notes"></textarea>
        </div>
      </div>
     

    </div>

    <div id="response" class="text-success"></div>

    <div class="card-footer text-center">
      <!-- <input type="hidden" name="hid" value="<?php echo $_REQUEST['mode']?>"> -->
      <input type="hidden" name="id" value="<?php echo $rows['id']?>">
      <button class="btn btn-primary" type="submit">Submit</button>
      <button type="button" onclick="goBack()" class="btn btn-outline-primary">Cancel</button>
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
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
<script>
$(document).ready(function () {
  // Initialize form validation
  $("form").validate({
    rules: {
      // Validation rules for each input
     
      no_of_bags: {
        required: true,
        digits: true,
        min: 1
      },
    
      qwinta_rate: {
        required: true,
        number: true,
        min: 0.1
      },
      supplier:{
        required:true

      },
      mirchi_type:{
        required:true
      },
      bag_batch:{
        required:true
      }
    },
    messages: {
      // Custom messages for each field
    _of_bags: {
        required: "Please enter the number of bags.",
        digits: "Please enter a valid number.",
        min: "The number of bags must be at least 1."
      },
      qwinta_rate: {
        required: "Please enter the Quinta rate.",
        number: "Please enter a valid number.",
        min: "The qwinta rate must be at least 0.1."
      },
      supplier:{
        required:"Please select  the suplier"

      },
      mirchi_type:{
        required:"please select mirchi variant"
      },
      bag_batch:{
        required:"Please Select PVT Mark"
      }
    },
    submitHandler: function(form) {
      form.submit(); // Submit the form if validation passes
    }
  });
});
  document.getElementById("qwinta_rate").addEventListener("input", calculateAmounts);
document.getElementById("net_weight").addEventListener("input", calculateAmounts);
document.getElementById("gunnies_bag").addEventListener("input", calculateAmounts);
document.getElementById("gunnies_bag_rate").addEventListener("input", calculateAmounts);

function calculateAmounts() {
  var netWeight = parseFloat(document.getElementById("net_weight").value) || 0;
  var qwintaRate = parseFloat(document.getElementById("qwinta_rate").value) || 0;
   qwintaRate = qwintaRate / 100;
  var grassAmount = netWeight * qwintaRate;

  var gunniesBag = parseFloat(document.getElementById("gunnies_bag").value) || 0;
  var gunniesBagRate = parseFloat(document.getElementById("gunnies_bag_rate").value) || 0;
  var gunniesBagTotal = gunniesBag * gunniesBagRate;

  document.getElementById("grass_amount").value = grassAmount.toFixed(2);
  document.getElementById("gunnies_bag_total").value = gunniesBagTotal.toFixed(2);
}
</script>

  </body>
</html>