<?php
session_start(); // Start the session to store success/error messages
include_once('db-connect.php'); // Include the database connection
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
      width:90px;
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
.bg-footer{
  background-color:#d6e8e7;
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
                <h2>Today Report</h2>
              </div>
              <div class="col-sm-6 col-12">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index-m.php"><i class="iconly-Home icli svg-color"></i></a></li>
                  <li class="breadcrumb-item active">Today Report</li>
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
                      <div class="table-responsive">
              <table class="display" id="basic-1">
    <thead>
        <tr>
            <th>Sl.No</th>
            <th>Supplier</th>
            <th>PVT Marks</th>
            <th>Lot Number</th>
            <th>Number of Bags</th>
            <th>Rate Per qtl</th>
            <th>Gross Weight kgs</th>
            <th>Gross Amount Rs</th> <!-- Correct column name -->
            <th>Net Weight kgs</th>
            <th>Gunnies Amount Rs</th>
            <th>Total Amount Rs</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $currentDate = date('Y-m-d');

        // Ensure user_id and merchant_id are set
        if ($_SESSION['user_id'] == $_SESSION['merchant_id']) {
            $user_id = $_SESSION['user_id'];  // Use user_id if they are equal
        } else {
            $user_id = $_SESSION['merchant_id'];  // Use merchant_id if they are different
        }
        
        // SQL query to select data where the date is equal to today's date and user_id matches
        $query = "SELECT 
                    '$currentDate' AS `date`, 
                    GROUP_CONCAT(DISTINCT `pvt_mark` ORDER BY `pvt_mark` ASC) AS `pvt_mark`, 
                    SUM(CAST(`no_of_bags` AS UNSIGNED)) AS `no_of_bags`, 
                    SUM(CAST(`net_weight` AS DECIMAL(10,2))) AS `net_weight`, 
                    `supplier`, 
                    SUM(CAST(`grosswt` AS DECIMAL(10,2))) AS `grosswt`, 
                    SUM(CAST(`gross_amount` AS DECIMAL(10,2))) AS `gross_amount`,
                    SUM(CAST(`total_amount` AS DECIMAL(10,2))) AS `total_amount`, 
                    SUM(CAST(`gunnies_bag_rate` AS DECIMAL(10,2))) AS `gunnies_bag_rate`, 
                    SUM(CAST(`gunnies_bag_total` AS DECIMAL(10,2))) AS `gunnies_bag_total`, 
                    GROUP_CONCAT(DISTINCT `lot_no` ORDER BY `lot_no` ASC) AS `lot_no`, 
                    '20kg' AS `bag_weight`, 
                    SUM(CAST(`rate_per_kg` AS DECIMAL(10,2))) AS `rate_per_kg`, 
                    1 AS `status` 
                  FROM `weight` 
                  WHERE `status` = 1 
                    AND `date` = '$currentDate' 
                    AND `user_id` = '$user_id'  
                  GROUP BY `supplier`";

        // Execute the query
        $result = mysqli_query($conn, $query);

        // Initialize totals accumulator
        $grandTotalNoOfBags = 0;
        $grandTotalGrossWeight = 0;
        $grandTotalNetWeight = 0;
        $grandTotalAmount = 0;
        $grandTotalGunniesAmount = 0; // Accumulator for Guns Amount

        // Check if there are results
        if ($result && mysqli_num_rows($result) > 0) {
            // Loop through the results and display them in the table
            while ($row = mysqli_fetch_assoc($result)) {
                // Get the supplier ID
                $supplierId = $row['supplier'];  

                // Query to fetch supplier name using the supplier ID
                $supplierQuery = "SELECT `supplier` FROM `suppliers` WHERE `id` = $supplierId";
                $supplierResult = mysqli_query($conn, $supplierQuery);

                // Fetch the supplier row (without loop)
                $supplierRow = mysqli_fetch_assoc($supplierResult);
                $supplierName = $supplierRow ? $supplierRow['supplier'] : 'Unknown Supplier';

                // Initialize totals for the current supplier
                $totalNoOfBags = $row["no_of_bags"];
                $totalGrossWeight = $row["grosswt"];
                $totalNetWeight = $row["net_weight"];
                $totalAmount = $row["total_amount"];
                $totalGunniesAmount = $row["gunnies_bag_total"];
                $totalGrossAmount = $row["gross_amount"];
                // Accumulate grand totals
                $grandTotalNoOfBags += $totalNoOfBags;
                $grandTotalGrossWeight += $totalGrossWeight;
                $grandTotalNetWeight += $totalNetWeight;
                $grandTotalAmount += $totalAmount;
                $grandTotalGunniesAmount += $totalGunniesAmount;
                $grandTotalGrossAmount += $totalGrossAmount;

                // Display supplier total above the individual data for that supplier
                ?>
                <tr>
                    <td colspan="11" style="font-weight: bold; background-color: #fffed3; text-align: left;">
                        <?php echo $supplierName; ?> - Total
                    </td>
                </tr>

                <!-- Get current date and query to get data for the specific supplier -->
                <?php
                $sql = "SELECT * FROM weight 
                        WHERE supplier = $supplierId 
                        AND status = 1 
                        AND date = '$currentDate' 
                        AND user_id = '$user_id'";

                // Execute the query
                $supplierDataResult = mysqli_query($conn, $sql);

                // Loop through each row for the specific supplier
                if ($supplierDataResult && mysqli_num_rows($supplierDataResult) > 0) {
                    $i = 1; // Initialize serial number for each row
                    while ($rows = mysqli_fetch_assoc($supplierDataResult)) {
                        ?>
                        <tr>
                            <td><?php echo $i++; ?></td> <!-- Increment serial number -->
                            <td><?php echo $supplierName; ?></td> <!-- Display supplier name -->
                            <td><?php echo $rows["pvt_mark"]; ?></td>
                            <td><?php echo $rows["lot_no"]; ?></td>
                            <td><?php echo $rows["no_of_bags"]; ?></td>
                            <td><?php echo $rows['rate_per_kg'] * 100; ?></td> <!-- Rate Per qtl -->
                            <td><?php echo $rows['grosswt']; ?></td> <!-- Gross Weight kgs -->
                            <td><?php echo $rows['gross_amount']; ?></td> <!-- Gross Amount Rs -->
                            <td><?php echo $rows["net_weight"]; ?></td> <!-- Net Weight kgs -->
                            <td><?php echo $rows['gunnies_bag_total']; ?></td> <!-- Gunnies Amount Rs -->
                            <td><?php echo $rows["total_amount"]; ?></td> <!-- Total Amount Rs -->
                        </tr>
                        <?php
                    }
                }
                ?>

                <!-- Display supplier total right after the individual rows -->
                <tr>
                    <td colspan="3" style="text-align: left; font-weight: bold;">Supplier Total</td>
                    <td style="font-weight: bold;"></td>
                     <td style="font-weight: bold;"><?php echo number_format($totalNoOfBags); ?></td>
                    <td style="font-weight: bold;"></td>
                    <td style="font-weight: bold;"><?php echo number_format($totalGrossWeight, 2); ?></td>
                    <td style="font-weight: bold;"><?php echo number_format($totalGrossAmount, 2); ?></td>
                    <td style="font-weight: bold;"><?php echo number_format($totalNetWeight, 2); ?></td>
                    <td style="font-weight: bold;"><?php echo number_format($totalGunniesAmount,2);?></td>
                    <td style="font-weight: bold;"><?php echo number_format($totalAmount, 2); ?></td>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
    <tfoot class="bg-footer">
        <tr>
            <td colspan="3" style="text-align: left; font-weight: bold;">Grand Total</td>
            <td style="font-weight: bold;"></td>
            <td style="font-weight: bold;"><?php echo number_format($grandTotalNoOfBags); ?></td>
            <td style="font-weight: bold;"></td>
            <td style="font-weight: bold;"><?php echo number_format($grandTotalGrossWeight, 2); ?></td>
          
            <td style="font-weight: bold;"><?php echo number_format($grandTotalGrossAmount, 2); ?></td>
            <td style="font-weight: bold;"><?php echo number_format($grandTotalNetWeight, 2); ?></td>
            <td style="font-weight: bold;"><?php echo number_format($grandTotalGunniesAmount,2);?></td>
            <td style="font-weight: bold;"><?php echo number_format($grandTotalAmount, 2); ?></td>
        </tr>
        <tr>
            <td colspan="11" style="font-weight: bold;"> Date : <?php echo $currentDate; ?> </td>
        </tr>
    </tfoot>
</table>
                 </div>
                   
      <div class="card-footer text-center">
      <button onclick="printTable()" class="btn btn-primary">Print Table</button>
          
          <button type="button" onclick="goBack()" class="btn btn-outline-primary">Cancel</button>
    
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

   
// go back function
function goBack() {
        window.history.back();  // This will navigate to the previous page
    }
    function printTable() {
        var printContents = document.getElementById('basic-1').outerHTML; // Get table HTML
        var originalContents = document.body.innerHTML; // Save original HTML

        document.body.innerHTML = printContents; // Replace body content with the table
        window.print(); // Trigger the print dialog
        document.body.innerHTML = originalContents; // Restore original content after printing
    }

  </script>
</body>

</html>