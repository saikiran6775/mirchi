<?php
session_start(); // Start the session to store success/error messages
include_once('db-connect.php'); // Include the database connection
// Check if the user is logged in by verifying session variables
if (!isset($_SESSION['user_id'])) {
    // If user is not logged in, redirect to login page
    header('Location: marchant-login.php');
    exit(); // Stop further execution
}

// Check if the user is logged in by verifying session variables
if (!isset($_SESSION['user_id']) || !isset($_SESSION['merchant_id'])) {
    echo "Error: Session variables not set properly.";
    exit(); // Stop further execution if session variables are not set
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
// Ensure all POST data is sanitized
$date = mysqli_real_escape_string($conn, $_POST['date']);
$farmer_name = mysqli_real_escape_string($conn, $_POST['farmer_name']);
$farmer_location = mysqli_real_escape_string($conn, $_POST['farmer_location']);
$buyer_name = mysqli_real_escape_string($conn, $_POST['buyer_name']);
$pvt_mark = mysqli_real_escape_string($conn, $_POST['bag_batch']);
$no_of_bags = (int)$_POST['no_of_bags']; // Ensure this is an integer
$gross_weight = (float)$_POST['grosswt']; // Ensure it's a float
$net_weight = (float)$_POST['net_weight']; // Ensure it's a float
$total_amount = (float)$_POST['total_amount']; // Ensure it's a float
$gunny_bag_rate = (float)$_POST['gunnies_bag_rate']; // Ensure it's a float
$gunny_bag_total = (float)$_POST['gunnies_bag_total']; // Ensure it's a float
$lot_no = (int)$_POST['desire_no_bag']; // Ensure this is an integer
$rate_per_kg = (float)$_POST['rate_per_kg']; // Ensure it's a float
$gross_amount = (float)$_POST['grossamount']; // Ensure it's a float
$commission_per = (float)$_POST['commission_per']; // Ensure it's a float
$expenditure = (float)$_POST['expenditure']; // Ensure it's a float
$expenditure_amount = (float)$_POST['expenditure_amount']; // Ensure it's a float
$total_seller_amount = (float)$_POST['total_seller_amount']; // Ensure it's a float

// Initialize weights array
$weights = [];

// Loop through the bags and collect their weights
for ($i = 0; $i < $no_of_bags; $i++) {
    if (isset($_POST['shop_no_' . $i])) {
        $weight = $_POST['shop_no_' . $i];
        if (!empty($weight)) {
            $weights[] = mysqli_real_escape_string($conn, $weight);
        }
    }
}

// Join weights array into a comma-separated string, or set an empty string if no weights
$weightsStr = (count($weights) > 0) ? implode(",", $weights) : '';

// Determine which user_id to use (session check)
if ($_SESSION['user_id'] == $_SESSION['merchant_id']) {
    $user_id = $_SESSION['user_id'];  // Use user_id if they are equal
} else {
    $user_id = $_SESSION['merchant_id'];  // Use merchant_id if they are different
}

// Insert query to add weight calculation into the database
$sql = "INSERT INTO importer_weight 
        (date, farmer_name, farmer_location, buyer_name, bag_batch, rate_per_kg, commission_per, expenditure, desire_no_bag, no_of_bags, bag_weight, grosswt, grossamount, gunnies_bag_rate, net_weight, gunnies_bag_total, total_amount, commission_amount, expenditure_amount, total_seller_amount, status, user_id) 
        VALUES 
        ('$date', '$farmer_name', '$farmer_location', '$buyer_name', '$pvt_mark', '$rate_per_kg', '$commission_per', '$expenditure', '$lot_no', '$no_of_bags', '$weightsStr', '$gross_weight', '$gross_amount', '$gunny_bag_rate', '$net_weight', '$gunny_bag_total', '$total_amount', '$commission_per', '$expenditure_amount', '$total_seller_amount', 1, '$user_id')";

// Execute the insert query
if (mysqli_query($conn, $sql)) {
    $_SESSION['message'] = "Weight Calculation updated successfully!";
    $_SESSION['status'] = "success";
} else {
    $_SESSION['message'] = "Failed to update Weight Calculation: " . mysqli_error($conn);
    $_SESSION['status'] = "error";
}

// Redirect back to the manage page after processing
header('Location: manage-seller.php');
exit();
}
    

if (isset($_GET['hid']) && $_GET['hid'] == 'delete' && isset($_GET['id'])) {
    // Ensure ID is a valid integer
    $id = intval($_GET['id']); 
    
    // Debugging line (you can remove this after confirming it works)
    // echo $id; 
    
    if ($id > 0) { // Check if ID is a valid positive integer
        // Prepare the SQL statement for soft delete
        $delete_sql = "UPDATE  importer_weight SET status = 0 WHERE id = ?";
        
        if ($stmt = mysqli_prepare($conn, $delete_sql)) {
            // Bind the parameters
            mysqli_stmt_bind_param($stmt, "i", $id);
  
            // Execute the statement
            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['message'] = "Weight Calculation deactivated successfully!";
                $_SESSION['status'] = "success";
                header('Location: manage-seller.php');
                exit();
            } else {
                $_SESSION['message'] = "Failed to deactivate Weight Calculation.";
                $_SESSION['status'] = "error";
            }
            mysqli_stmt_close($stmt);
        } else {
            $_SESSION['message'] = "Error in preparing delete query.";
            $_SESSION['status'] = "error";
        }
    } else {
        // If ID is not valid, set an error message
        $_SESSION['message'] = "Invalid ID provided.";
        $_SESSION['status'] = "error";
    }
    // Redirect back to the manage page after processing
    header('Location: manage-seller.php');
    exit();}



$bag_weights = isset($row['bag_weight']) ? explode(',', $row['bag_weight']) : [];
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
     margin-bottom:5px;
    
    }
    .form-label{
      margin-bottom:2px;
    }
    .form-select{
   
   margin-bottom:10px;
    padding-left:15px;
    padding-right:10px;
    padding-top:0px;
    padding-bottom:0px;
     border-radius:0px;
  
}
.custom-weight{
      width:90px;
      margin-left:3px;
      border-radius:5px;
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
div .action .preview i{
  color:#009cff;
}
.custom-gap{
    margin-bottom: 5px;
}
  </style>
</head>

<body>
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
            <button type="button" class="btn btn-primary px-4"  onclick="goBack()" id="closeModal">OK</button>
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
                <h2>Seller Weight calculation</h2>
              </div>
              <div class="col-sm-6 col-12">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index-m.php"></a></li>
                  <li class="breadcrumb-item active">Seller Weight calculation</li>
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
      <button type="button" class="btn btn-success btn-icon-text" style="float:left"
        onclick="location.href='manage-seller.php?mode=add'">
        <i class="icon-plus"></i> Add Seller Weight Calculation
      </button>
    </div>

    <table class="display" id="basic-1">
      <thead>
        <tr>
          <th>Sl.No</th>
          <th>Farmer Name</th>
          <th>Farmer Location</th>
          <th>PVT Mark</th>
          <th>Number of Bags</th>
          <th>Net Weight</th>
          <th>Total Amount</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Determine the correct user_id
        $user_id = ($_SESSION['user_id'] == $_SESSION['merchant_id']) ? $_SESSION['user_id'] : $_SESSION['merchant_id'];

        // Fetch all records for the user (remove CURDATE filter)
        $sql = "SELECT * FROM importer_weight WHERE status = '1' AND user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        $i = 0;
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $i++;
        ?>
            <tr>
              <td><?php echo $i; ?></td>
              <td><?php echo htmlspecialchars($row["farmer_name"]); ?></td>
              <td><?php echo htmlspecialchars($row["farmer_location"]); ?></td>
              <td><?php echo htmlspecialchars($row["bag_batch"]); ?></td>
              <td><?php echo htmlspecialchars($row["no_of_bags"]); ?></td>
              <td><?php echo htmlspecialchars($row["net_weight"]); ?></td>
              <td><?php echo htmlspecialchars($row["total_amount"]); ?></td>
              <td>
                <ul class="action">
                  <li class="preview mx-2">
                    <a href="preview-seller.php?id=<?php echo urlencode($row['id']); ?>">
                      <i class="fa-regular fa-eye"></i>
                    </a>
                  </li>
                  <li class="edit">
                    <a href="edit-seller.php?id=<?php echo urlencode($row['id']); ?>">
                      <i class="icon-pencil-alt"></i>
                    </a>
                  </li>
                  <li class="delete">
                    <a href="manage-seller.php?hid=delete&id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this record?');">
                      <i class="icon-trash"></i>
                    </a>
                  </li>
                </ul>
              </td>
            </tr>
        <?php
          }
        } else {
          // If no data found, show a row
          echo '<tr><td colspan="8" class="text-center">No records found.</td></tr>';
        }
        ?>
      </tbody>
    </table>
  </div>
<?php
}
else {
                    ?>
                                  <?php
                              
                                  

 $date="";
 $pvt_mark = "";
 $no_of_bags = "";
 $gross_weight= "";
 $net_weight = "";
 $total_amount = "";
 $gunny_bag_rate= "";
 $gunny_bag_total="";
 $bag_weights="";  
 $rate_per_kg="";
 $total_amount="";
 $lot_no="";
 $supplier_id="";

?>               
                    <!-- close more-edit -->
                    <div class="row">
                    <form class="card" id="loginForm" enctype="multipart/form-data" method="post">
    <div class="card-header card-no-border pb-0">
        <div class="card-options">
            <a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
            <a class="card-options-remove" href="#" data-bs-toggle="card-remove"><i class="fe fe-x"></i></a>
        </div>
    </div>
    <div class="card-body">
        <div class="row mx-4 custom-gap">
            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label">Date of Purchase</label>
                    <input type="text" class="form-control" id="date" name="date" value="<?php echo ($_REQUEST['mode'] == 'edit') ? $date : date('Y-m-d'); ?>" readonly>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Farmer Name</label>
                   <input type="text" class="form-control" id="farmer_name" name="farmer_name" >
                </div>
            </div>                 
        </div>
        <div class="row mx-4  custom-gap">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Farmer Location</label>
                    <input type="text" class="form-control" id="farmer_location" name="farmer_location" required>
                </div>
            </div>

            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label">Buyer Name</label>
                    <input type="text" class="form-control" id="buyer_name" name="buyer_name"  required>
                </div>
            </div>
        </div>

        <div class="row mx-4  custom-gap">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">PVT.Mark</label>
                    <input type="text" class="form-control" id="bag_batch" name="bag_batch" value="<?php echo $pvt_mark;?>" required>
                </div>
            </div>

            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label">Rate Per Kg</label>
                    <input type="text" class="form-control" id="rate_per_kg" name="rate_per_kg" value="<?php echo $rate_per_kg;?>" required>
                </div>
            </div>
        </div>
        <div class="row mx-4  custom-gap">
        <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label">commission in Percentage</label>
                    <input type="number" class="form-control" id="commission_per" name="commission_per" >
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label">Expenditure</label>
                    <input type="number" class="form-control" id="expenditure" name="expenditure" value="<?php echo $total_amount;?>">
                </div>
            </div>
        </div>

        <div class="row mx-4 custom-gap">
            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label">Lot Number</label>
                    <input type="text" name="desire_no_bag" class="form-control" id="fieldCount" oninput="handleKeyPress(this)">
                    <div id="lotNoMessage" class="mt-2"></div> 
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label">No Of Gunny Bags</label>
                    <input type="text" class="form-control" id="no_of_bags" name="no_of_bags" oninput="handleKeyPress(this)">
                </div>
            </div>
        </div>

        <div class="row text-center">
            <label class="form-label">Enter Weights</label>
            <div id="weights-calculation" class="weights-caluculation mx-4 mb-5"></div>
        </div> 
       

        <div class="row mx-4 custom-gap">
            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label">Gross Weight</label>
                    <input type="text" class="form-control" id="grosswt" name="grosswt" value="<?php echo $gross_weight; ?>" readonly>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label">Gross Amount</label>
                    <input type="text" class="form-control" id="gross_amount" name="grossamount" value="<?php echo $gross_weight; ?>" readonly>
                </div>
            </div>
            
        </div>

        <div class="row mx-4 custom-gap">
        <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label">No Of Gunny Bags</label>
                    <input type="text" class="form-control" id="gunnies" name="gunnies" readonly>
                </div>
            </div>
        <div class="col-md-6">
              <div class="form-group">
                  <label class="form-label">Gunny Bag Cost (each)</label>
                  <?php
                  $sql = "SELECT * FROM gunny_bag"; 
                  $result = mysqli_query($conn, $sql);
                  if ($result && mysqli_num_rows($result) > 0) {
                      $row = mysqli_fetch_array($result);
                      $gunny_bag_rate = $row['gunny_bag']; 
                  } else {
                      $gunny_bag_rate = ""; 
                  }
                  ?>
                  <input type="number" class="form-control" id="gunnies_bag_rate" name="gunnies_bag_rate" value="<?php echo $gunny_bag_rate; ?>" readonly>
              </div>
          </div>
       
            
        </div>
      

        <div class="row mx-4 custom-gap">
        <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label">Total Gunny Bags Amount</label>
                    <input type="number" class="form-control" id="gunnies_bag_total" name="gunnies_bag_total" value="<?php echo $gunny_bag_total; ?>" readonly>
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label">Net Weight</label>
                    <input type="number" class="form-control" id="net_weight" name="net_weight" value="<?php echo $net_weight; ?>" readonly>
                </div>
            </div>
           
            
        </div>
        <div class="row mx-4 custom-gap">
       
        <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label">Total Seller Amount</label>
                    <input type="number" class="form-control" id="total_seller_amount" name="total_seller_amount" value="<?php echo $total_amount;?>">
                </div>
            </div>
            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label">Commission Amount</label>
                    <input type="number" class="form-control" id="commission_amount" name="commission_amount" value="<?php echo $total_amount;?>" readonly>
                </div>
            </div>
            
        </div>
      
        <div class="row mx-4 custom-gap">
        <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label">Expenditure Amount</label>
                    <input type="number" class="form-control" id="expenditure_amount" name="expenditure_amount" value="<?php echo $total_amount;?>" readonly>
                </div>
            </div>
        <div class="col-sm-6 col-md-6">
             <div class="form-group">
                    <label class="form-label">total Weight Amount</label>
                    <input type="number" class="form-control" id="total_amount" name="total_amount" value="<?php echo $total_amount;?>" readonly>
                </div>
               
            </div>
        </div>

        <div id="response" class="text-success"></div>
        <div class="card-footer text-center">
            <input type="hidden" name="id" value="">
            <button class="btn btn-primary" type="submit">Submit</button>
            <button type="button" onclick="goBack()" class="btn btn-outline-primary">Cancel</button>
        </div>
    </div>
</form>     <?php
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

  <!-- Load jQuery first -->
<script src="assets/js/vendors/jquery/jquery.min.js"></script>

<!-- Bootstrap JS (Bundle includes Popper.js) -->
<!-- <script src="assets/js/vendors/bootstrap/dist/js/bootstrap.bundle.min.js" defer=""></script> -->

<!-- Font Awesome -->
<script src="assets/js/vendors/font-awesome/fontawesome-min.js"></script>

<!-- Sidebar -->
<script src="assets/js/sidebar.js"></script>

<!-- Scrollbar -->
<script src="assets/js/scrollbar/simplebar.js"></script>
<script src="assets/js/scrollbar/custom.js"></script>

<!-- Slick Carousel -->
<script src="assets/js/slick/slick.min.js"></script>
<script src="assets/js/slick/slick.js"></script>

<!-- Datatables -->
<script src="assets/js/datatable/datatables/jquery.dataTables.min.js"></script>
<script src="assets/js/js-datatables/datatables/datatable.custom.js"></script>

<!-- Page Datatable (if applicable) -->
<!-- <script src="assets/js/datatable/datatables/datatable.custom.js"></script> -->

<!-- Custom Script (for your specific page logic) -->
<script src="assets/js/script.js"></script>

<!-- jQuery Validation (ensure it's loaded after jQuery) -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<!-- Popper.js (Only if needed, remove if using Bootstrap bundle) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

<!-- Bootstrap (Only if needed, remove if using Bootstrap bundle) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<!-- jQuery CDN -->
<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- jQuery Validation Plugin -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>



<!-- Password Script (ensure it's after jQuery) -->
<!-- <script src="assets/js/password.js"></script> -->
<script>
    $(document).ready(function() {
    // Initialize the form validation
    $('#loginForm').validate({
        rules: {
            // Validation for "No Of Bags"
            no_of_bags: {
                required: true,
                min: 1
            },
            // Validation for "Rate Per Kg"
            rate_per_kg: {
                required: true,
                number: true,
                min: 0.01 // To ensure it's a positive number
            },
            // Validation for "Lot Number"
            lot_no: {
                required: true,
                digits: true,
                min: 1 // Lot number should be a positive integer
            },
            // Validation for "PVT Mark"
            bag_batch: {
                required: true
            },
            // Validation for "Supplier"
            supplier: {
                required: true
            },
            // Validation for dynamically generated "Shop No." fields
            // Loop through the dynamically created shop number fields
            // Add validation for each field based on how many you have
            // Assuming you have a dynamic number of fields and their IDs follow the pattern shop_no_1, shop_no_2, etc.
            ...getShopNumberValidationRules()
        },
        messages: {
            // Custom messages for each field
            no_of_bags: {
                required: "Please enter the number of bags",
                min: "Number of bags must be at least 1"
            },
            rate_per_kg: {
                required: "Please enter the rate per kg",
                number: "Please enter a valid number",
                min: "Rate must be greater than 0"
            },
            lot_no: {
                required: "Please enter the lot number",
                digits: "Lot number must be a positive integer",
                min: "Lot number must be at least 1"
            },
            bag_batch: {
                required: "Please select a PVT Mark"
            },
            supplier: {
                required: "Please select a supplier"
            },
            // Custom messages for dynamically generated fields (e.g., shop_no_1, shop_no_2)
            ...getShopNumberMessages()
        },
        // Optional: Customizing error placement if needed
        errorPlacement: function(error, element) {
            error.appendTo(element.closest('.form-group'));
        },
        // You can handle the form submission without alert
        submitHandler: function(form) {
            // Proceed with form submission if valid (submit via Ajax or normal form submit)
            form.submit(); // Or use $.ajax(...) if needed for AJAX submission
        }
    });

    // Function to get dynamic validation rules for shop number fields
    function getShopNumberValidationRules() {
        let rules = {};
        let numBags = $('#no_of_bags').val(); // Get the number of bags

        for (let i = 1; i <= numBags; i++) {
            rules["shop_no_" + i] = {
                required: true // Making each dynamically generated shop number input field required
            };
        }

        return rules;
    }

    // Function to get dynamic validation messages for shop number fields
    function getShopNumberMessages() {
        let messages = {};
        let numBags = $('#no_of_bags').val(); // Get the number of bags

        for (let i = 1; i <= numBags; i++) {
            messages["shop_no_" + i] = {
                required: "Please enter the weight for bag " + i
            };
        }

        return messages;
    }

    // Event to trigger validation whenever the number of bags is changed
    $('#no_of_bags').on('change', function() {
        // Revalidate the form when the number of bags is updated
        $('#loginForm').validate().element($(this));
    });
});
    // Popup Widnow *********************
    // *******************************
    document.addEventListener("DOMContentLoaded", function () {
  // Check if the modal element exists before initializing the modal
  const modalElement = document.getElementById('messageModal');
  
  // Only initialize the modal if the element exists
  if (modalElement) {
    var myModal = new bootstrap.Modal(modalElement);
    myModal.show(); // Show modal when page loads

    // Countdown Timer for Auto-Redirect
    let timeLeft = 3;
    const countdown = document.getElementById("countdown");

    const interval = setInterval(function () {
      timeLeft--;
      countdown.innerText = timeLeft;
      if (timeLeft <= 0) {
        clearInterval(interval);
        window.location.href = "manage-seller.php"; // Redirect to the target page
      }
    }, 1000);

    // Close Modal and Redirect Immediately on Button Click
    document.getElementById("closeModal").addEventListener("click", function () {
      clearInterval(interval); // Stop the countdown
      window.location.href = "manage-seller.php"; // Redirect to the target page
    });
  }
});


// calculation starts==================================
// Variables to track the number of key presses
let keyPressCount = 0;
const formFieldsContainer = document.getElementById('weights-calculation');
const ratePerKgInput = document.getElementById('rate_per_kg');
const gunnyBagRateInput = document.getElementById('gunnies_bag_rate');
const commissionPerInput = document.getElementById('commission_per');
const expenditureInput = document.getElementById('expenditure');

// Function to generate form fields based on the desired number of bags
function generateFormFields(desiredCount) {
    const existingFields = formFieldsContainer.querySelectorAll('.input-field input');
    const currentValues = Array.from(existingFields).map(input => input.value);

    // Clear the existing fields
    formFieldsContainer.innerHTML = '';

    // Generate the fields based on the desired count
    for (let i = 0; i < desiredCount; i++) {
        const fieldWrapper = document.createElement('div');
        fieldWrapper.classList.add('input-field');

        const inputField = document.createElement('input');
        inputField.type = 'text';
        inputField.className = "form-control custom-weight mb-2";
        inputField.classList.add('bag-weight-input');
        inputField.placeholder = `Bag ${i + 1}`;
        inputField.name = "shop_no_" + i;
        inputField.required = true;

        // Restore value if there was a previously entered value
        if (i < currentValues.length) {
            inputField.value = currentValues[i];
        }

        // Add event listener to trigger calculations when weight is entered
        inputField.addEventListener('input', performCalculations);

        fieldWrapper.appendChild(inputField);
        formFieldsContainer.appendChild(fieldWrapper);
    }

    // Perform calculations after generating the fields
    performCalculations();
}

// Function to handle key press and trigger field generation
function handleKeyPress(input) {
    keyPressCount++;

    // Wait for the second key press before triggering
    if (keyPressCount === 2) {
        let value = parseInt(input.value) || 0;

        // Validate that the value is between 1 and 99 (inclusive)
        if (value >= 1 && value <= 99) {
            generateFormFields(value); // Generate fields based on the value entered
        }

        keyPressCount = 0; // Reset key press count after handling
    }
}

// Function to perform the calculation
function performCalculations() {
    let totalWeight = 0;
    let bagInputs = document.querySelectorAll(".bag-weight-input");

    // Sum up the total weight from all bag inputs
    bagInputs.forEach(function(input) {
        let weight = parseFloat(input.value) || 0;
        totalWeight += weight;
    });

    const numBags = bagInputs.length;
    const ratePerKg = parseFloat(ratePerKgInput.value) || 0;
    const gunnyBagCost = parseFloat(gunnyBagRateInput.value) || 0;
    const commissionPer = parseFloat(commissionPerInput.value) || 0;
    const expenditure = parseFloat(expenditureInput.value) || 0;

    // Calculate gross amount, net weight, total cost, commission, and seller amount
    const grossAmount = totalWeight * ratePerKg;
    const netWeight = totalWeight - numBags; // Subtract number of bags for net weight
    const totalBagsCost = numBags * gunnyBagCost;
    const totalAmount = (netWeight * ratePerKg) + totalBagsCost;
    const commissionAmount = totalAmount * (commissionPer / 100);
    const expenditureAmount = expenditure * numBags;
    const totalSellerAmount = totalAmount + commissionAmount + expenditureAmount;

    // Update form fields with the calculated values
    document.getElementById("no_of_bags").value = numBags;
    document.getElementById("gunnies").value = numBags;
    document.getElementById("grosswt").value = totalWeight.toFixed(2);
    document.getElementById("gross_amount").value = grossAmount.toFixed(2);
    document.getElementById("net_weight").value = netWeight.toFixed(2);
    document.getElementById("gunnies_bag_total").value = totalBagsCost.toFixed(2);
    document.getElementById("total_amount").value = totalAmount.toFixed(2);
    document.getElementById("commission_amount").value = commissionAmount.toFixed(2);
    document.getElementById("expenditure_amount").value = expenditureAmount.toFixed(2);
    document.getElementById("total_seller_amount").value = totalSellerAmount.toFixed(2);
}

// Attach the input event listener to the "Desired No Of Bags" input field
document.getElementById('fieldCount').addEventListener('input', function(e) {
    performCalculations();  // Recalculate whenever input changes
});
// ====================================================

// Go back function
function goBack() {
    window.history.back();  // This will navigate to the previous page
}

// Trigger an initial field generation on page load with the default value
document.getElementById('fieldCount').dispatchEvent(new Event('input')); 
 
$(document).ready(function () {
    $("input[name='desire_no_bag']").on("keyup", function () {
        let lotNumber = $(this).val().trim();  // Get the value of the Lot Number
        let id = $("input[name='id']").val(); // Get the ID (for edit mode)
        let mode = $("input[name='hid']").val(); // Check if it's add or edit mode

        if (lotNumber.length >= 3) { // Validate only if the lot number has at least 3 characters
            $.ajax({
                url: "validate.php",  // The PHP script to validate the lot number
                type: "POST",
                data: { desire_no_bag: lotNumber, id: id, mode: mode },  // Pass the lot number, ID, and mode
                success: function (response) {
                    // Handle server response
                    if (response.trim() === "not available") {
                        $("#lotNoMessage").text("Lot Number not available for today!").css("color", "red");
                        $("button[type='submit']").prop("disabled", true);  // Disable the submit button if not available
                    } else if (response.trim() === "available") {
                        $("#lotNoMessage").text("Lot Number is available.").css("color", "green");
                        $("button[type='submit']").prop("disabled", false);  // Enable the submit button if available
                    } else {
                        $("#lotNoMessage").text("Invalid Lot Number.").css("color", "orange");
                        $("button[type='submit']").prop("disabled", true);  // Disable the submit button if invalid
                    }
                },
                error: function () {
                    $("#lotNoMessage").text("There was an error with the validation.").css("color", "red");
                }
            });
        }
    });
});



</script>
</body>

</html>