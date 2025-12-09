<?php
session_start(); // Start the session to store success/error messages
include_once('db-connect.php'); // Include the database connection?>


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
    .form-select{
   
   margin-bottom:10px;
    padding-left:15px;
    padding-right:10px;
    padding-top:2px;
    padding-bottom:2px;
     border-radius:0px;
  
}
.custom-weight{
      width:80px;
      margin-left:3px;
    }
    .weights-caluculation {
    height: auto;
    width: auto;
    display: flex;
    flex-direction: row;
    flex-wrap:wrap;
    gap: 10px; /* Adds space between the columns */
    overflow: show; /* Hides any overflow */
}

.weights-caluculation input {
    margin-bottom: 10px; /* Adds margin between inputs */
    box-sizing: border-box;
}
.error{
  color:red;
}
.calculation{
    font-size:18px;
}
.calculation-card{
  width: auto;
    height: auto;
    color: #e8e9ea;
    background-color:#06867c;
    margin:30px auto;
}

  </style>
</head>

<body>
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
                <h2>Preview Stock Details</h2>
              </div>
              <div class="col-sm-6 col-12">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index-m.php"><i class="iconly-Home icli svg-color"></i></a></li>
                  <li class="breadcrumb-item active">Preview Stock Details</li>
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
                <?php // Ensure that the 'id' is passed in the request and sanitize it
$get_id = isset($_REQUEST['id']) ? (int) $_REQUEST['id'] : 0; // Casting to integer to prevent SQL injection
// Now use the sanitized $get_id in the query
$sql = "SELECT * FROM stock_details WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $get_id);
$stmt->execute();
$result = $stmt->get_result();

// Check if the query returns any results
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
?>
    <h1 class="text-center"><?php echo htmlspecialchars($row['supplier_name']); ?></h1>
    <div class="row mx-4">
        <div class="col-12 col-md-3"><b>Date: <?php echo date('d-M-Y', strtotime($row['date'])); ?></b></div>
        <div class="col-12 col-md-6"></div>
        <div class="col-12 col-md-3"></div>
    </div>
    <div class="row mx-4">
        <div class="col-12 col-md-9"></div>
        <div class="col-12 col-md-3"><b>Total No of Bags: <?php echo htmlspecialchars($row['total_no_bags']); ?></b></div>
    </div>
    <div class="table-responsive mx-4">
        <div class="mb-5">                   
            <h2 class="text-center"></h2>
        </div> 

        <table class="display" id="basic-1">
    <thead>
        <tr>
            <th>Sl.No</th>
            <th>No Of Bags</th>
            <th>PVT Mark</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Explode the PVT Mark values (bags_pvt) into an array
        $pvt_marks = explode(",", $row['bags_pvt']);
        
        // Loop through the PVT marks and display each in a new row
        for ($i = 0; $i < count($pvt_marks); $i++) {
            // Split the PVT Mark (e.g., '10_HVA') into its components
            $pvt_parts = explode("_", $pvt_marks[$i]);

            // Assuming PVT marks like '10_HVA', split into ['10', 'HVA']
            echo "<tr>";
            echo "<td>" . ($i + 1) . "</td>";  // Sl.No (Serial Number)
            echo "<td>" . htmlspecialchars($pvt_parts[0]) . "</td>";  // No Of Bags (e.g., '10' from '10_HVA')
            echo "<td>" . htmlspecialchars($pvt_parts[1]) . "</td>";  // PVT Mark (e.g., 'HVA')
            echo "</tr>";
        }
        ?>
    </tbody>
</table>

    </div>  
    
<?php
}
 else {
    echo "<p>No records found.</p>";
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
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<script>
      function goBack() {
    window.history.back();
  }
</script>
</body>
</html>