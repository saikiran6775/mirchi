<?php
// Start session
session_start();

// Include the database connection
include_once('db-connect.php');

// Check if the user is logged in by verifying session variables
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  // If user is not logged in or is not an admin, redirect to login page
  header('Location: weight-calculation.php');
  exit(); // Stop further execution
}

// If user is logged in and has the role of admin, continue execution
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $date = $_POST['date']; 
    $supplier_id = $_POST['supplier'];
    $pvt_mark = $_POST['bag_batch'];
    $no_of_bags = $_POST['no_of_bags'];
    $gross_weight = $_POST['grosswt'];
    $net_weight = $_POST['net_weight'];
    $total_amount = $_POST['total_amount'];
    $gunny_bag_rate = $_POST['gunnies_bag_rate'];
    $gunny_bag_total = $_POST['gunnies_bag_total'];
    $lot_no = $_POST['lot_no'];
    $rate_per_kg = $_POST['rate_per_kg'];

    // Sanitize and validate input
    $date = mysqli_real_escape_string($conn, $date);
    $supplier_id = mysqli_real_escape_string($conn, $supplier_id);
    $pvt_mark = mysqli_real_escape_string($conn, $pvt_mark);
    $no_of_bags = (int)$no_of_bags;
    $gross_weight = (float)$gross_weight;
    $net_weight = (float)$net_weight;
    $total_amount = (float)$total_amount;
    $gunny_bag_rate = (float)$gunny_bag_rate;
    $gunny_bag_total = (float)$gunny_bag_total;
    $lot_no = (int)$lot_no;

    // Initialize weights array
    $weights = [];
    for ($i = 1; $i <= $no_of_bags; $i++) {
        if (isset($_POST['shop_no_' . $i])) {
            $weight = $_POST['shop_no_' . $i];
            if (!empty($weight)) {
                $weights[] = mysqli_real_escape_string($conn, $weight);
            }
        }
    }

    // Join weights array into a comma-separated string
    $weightsStr = count($weights) > 0 ? implode(",", $weights) : '';

    // Prepare UPDATE query
    $id = (int) $_REQUEST['id'];
    $sql = "UPDATE weight SET
            date = '$date',
            supplier = '$supplier_id',
            pvt_mark = '$pvt_mark',
            no_of_bags = '$no_of_bags',
            grosswt = '$gross_weight',
            net_weight = '$net_weight',
            total_amount = '$total_amount',
            gunnies_bag_rate = '$gunny_bag_rate',
            gunnies_bag_total = '$gunny_bag_total',
            rate_per_kg = '$rate_per_kg',
            bag_weight = '$weightsStr',
            lot_no = '$lot_no'
            WHERE id= $id";  // Assuming 'lot_no' is the identifier for the record

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = " Weight Calculation get Updated successfully!";
        $_SESSION['status'] = "success";
    } else {
        $_SESSION['message'] = "Weight Calculation was unable to update.";
        $_SESSION['status'] = "error";
    }
     // Redirect back to the manage page after processing
 header('Location: weight-calculation.php');
 exit();
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
div .action .preview i{
  color:#009cff;
}
/* Media query for smaller screens (optional) */

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
                      <h2> Weight calculation
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
                  <?php
 $weight_id = isset($_REQUEST['id']) ? (int) $_REQUEST['id'] : 0;
 $sql = "SELECT * FROM weight WHERE id = $weight_id";
  $res = mysqli_query($conn, $sql);
  
  if ($res && mysqli_num_rows($res) > 0) {
      $rows = mysqli_fetch_array($res);
      $date = $rows["date"];
      $pvt_mark = $rows["pvt_mark"];
      $supplier_id = $rows["supplier"];
      $no_of_bags = $rows["no_of_bags"];
      $gross_weight = $rows["grosswt"];
      $net_weight = $rows["net_weight"];
      $total_amount = $rows["total_amount"];
      $gunny_bag_rate = $rows["gunnies_bag_rate"];
      $gunny_bag_total = $rows["gunnies_bag_total"];
      $bag_weights = $rows["bag_weight"];
      $rate_per_kg = $rows["rate_per_kg"];
      $total_amount = $rows["total_amount"];
      $lot_no= $rows['lot_no'];
      
  ?>
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
                  <input type="text" class="form-control" id="date" name="date" value="<?php echo $date; ?>" readonly>
              </div>
          </div>

          <div class="col-md-6">
              <div class="form-group">
                  <label class="form-label">Name of the Supplier</label>
                  <select class="form-select" id="supplier" name="supplier" required>
                      <option value="">Select Supplier</option>
                      <?php
                      // Query to fetch the supplier data
                      $result = mysqli_query($conn, "SELECT id, supplier FROM suppliers WHERE status=1");
                      while ($row = mysqli_fetch_assoc($result)) {
                          $selected = ($row['id'] == $supplier_id) ? 'selected' : ''; 
                          echo "<option value='{$row['id']}' {$selected}>{$row['supplier']}</option>";
                      }
                      ?>
                  </select>
              </div>
          </div>                 
      </div>

      <div class="row mx-4">
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

      <div class="row mx-4">
          <div class="col-sm-6 col-md-6">
              <div class="form-group">
                  <label class="form-label">No Of Gunny Bags</label>
                  <input type="number" id="num_bags" class="form-control mb-3" value="<?php echo $no_of_bags; ?>" min="1" onchange="generateWeightFields()">
                  <input type="hidden" class="form-control" id="no_of_bags" name="no_of_bags" value="<?php echo $no_of_bags;?>" readonly>
              </div>
          </div>

          <div class="col-sm-6 col-md-6">
              <div class="form-group">
                  <label class="form-label">Lot Number</label>
                  <input type="number" class="form-control" id="lot_no" name="lot_no" value="<?php echo $lot_no;?>">
              </div>
          </div>
      </div>

      <div class="row text-center">
          <label class="form-label">Enter Weights</label>
      </div> 
      <div id="weights-calculation" class="row weights-calculation mx-4 mb-5"></div>

      <div class="row mx-4">
          <div class="col-sm-6 col-md-6">
              <div class="form-group">
                  <label class="form-label">Gross Weight</label>
                  <input type="text" class="form-control" id="grosswt" name="grosswt" value="<?php echo $gross_weight; ?>" readonly>
              </div>
          </div>
          <div class="col-sm-6 col-md-6">
              <div class="form-group">
                  <label class="form-label">Net Weight</label>
                  <input type="number" class="form-control" id="net_weight" name="net_weight" value="<?php echo $net_weight; ?>" readonly>
              </div>
          </div>
      </div>

      <div class="row mx-4">
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

          <div class="col-sm-6 col-md-6">
              <div class="form-group">
                  <label class="form-label">Total Gunny Bags Amount</label>
                  <input type="number" class="form-control" id="gunnies_bag_total" name="gunnies_bag_total" value="<?php echo $gunny_bag_total; ?>" readonly>
              </div>
          </div>
      </div>

      <div class="row mx-4">
          <div class="col-sm-6 col-md-6">
              <div class="form-group">
                  <label class="form-label">Total Amount</label>
                  <input type="number" class="form-control" id="total_amount" name="total_amount" value="<?php echo $total_amount;?>" readonly>
              </div>
          </div>
      </div>

      <div id="response" class="text-success"></div>
      <div class="card-footer text-center">
          <input type="hidden" name="id" value="<?php echo $rows["id"]?>">
          <button class="btn btn-primary" type="submit">Submit</button>
          <button type="button" onclick="goBack()" class="btn btn-outline-primary">Cancel</button>
      </div>
  </div>
</form><?php }?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php
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
 <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
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

// Supplier Id******************************************************************************
// ******************************************************************************************
document.addEventListener("DOMContentLoaded", function () {
    var numBags = parseInt(document.getElementById("num_bags").value) || 0;
    var container = document.getElementById("weights-calculation");

    // PHP bag weights array passed to JavaScript
    var bagWeights = <?php echo json_encode($bag_weights); ?>; // Fetch values from PHP to JS

    // Clear any previously generated input fields
    container.innerHTML = "";

    // Check if the input number is valid and greater than 0
    if (numBags > 0) {
        // Generate the specified number of input fields
        for (let i = 1; i <= numBags; i++) {
            let inputField = document.createElement("input");
            inputField.type = "number";
            inputField.className = "form-control custom-weight mb-2 bag-weight-input";
            inputField.id = "shop_no_" + i;
            inputField.name = "shop_no_" + i;
            inputField.placeholder = "Bag " + i;

            <?php
          $weight_id = isset($_REQUEST['id']) ? (int) $_REQUEST['id'] : 0;
          $sql = "SELECT * FROM weight WHERE id = $weight_id";
          $res = mysqli_query($conn, $sql);
          $row = mysqli_fetch_array($res);
          
          // Assuming the bag weights are stored as a comma-separated string
          $bag_weights = isset($row['bag_weight']) ? explode(',', $row['bag_weight']) : [];
  ?>
          // PHP array values will be passed to JavaScript
          let bagWeight = <?php echo json_encode($bag_weights); ?>;

// Set the value of the input field with corresponding bag weight if available
inputField.value = bagWeight[i - 1] ? bagWeight[i - 1] : "";

container.appendChild(inputField);

// Attach the input event to each generated input field
inputField.addEventListener("input", function () {
    performCalculations(); // Trigger calculations on input change
            });
        }
    }

    // Perform initial calculations
    performCalculations();
});
let ratePerKgField = document.getElementById("rate_per_kg");
if (ratePerKgField) {
    ratePerKgField.addEventListener("input", function () {
        performCalculations(); // Trigger calculations when rate_per_kg changes
    });
}
// Function to perform the calculation
function performCalculations() {
    let totalWeight = 0;
    let bagInputs = document.querySelectorAll(".bag-weight-input");

    // Iterate through each bag weight input to calculate total weight
    bagInputs.forEach(function (input) {
        let weight = parseFloat(input.value) || 0;
        totalWeight += weight;
    });

    let numBags = bagInputs.length;
    let ratePerKg = parseFloat(document.getElementById("rate_per_kg").value) || 0;
    let gunnyBagCost = parseFloat(document.querySelector("input[name='gunnies_bag_rate']").value) || 0;

    let netWeight = totalWeight - numBags; // Subtract number of bags from total weight for net weight
    let totalBagsCost = numBags * gunnyBagCost;
    let totalAmount = (netWeight * ratePerKg) + totalBagsCost;

    // Update form fields with the calculated values
    document.getElementById("no_of_bags").value = numBags;
    document.getElementById("grosswt").value = totalWeight.toFixed(2);
    document.getElementById("net_weight").value = netWeight.toFixed(2);
    document.getElementById("gunnies_bag_total").value = totalBagsCost.toFixed(2);
    document.getElementById("total_amount").value = totalAmount.toFixed(2);

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
          window.location.href = "weight-calculation.php"; // Redirect to the target page
        }
      }, 1000);

      // Close Modal and Redirect Immediately on Button Click
      document.getElementById("closeModal").addEventListener("click", function () {
        clearInterval(interval); // Stop the countdown
        window.location.href = "weight-calculation.php"; // Redirect to the target page
      });
  });
  // Go back to previous page in the browser's history
function goBack() {
    window.history.back();
}

    </script>


  </body>
</html>