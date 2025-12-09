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
  <meta name="description" content="Mirchi CRM Admin Panel"/>
  <meta name="keywords" content="Mirchi CRM Admin Panel"/>
  <meta name="author" content="Mirchi CRM"/>
  <title>Mirchi CRM - Premium Admin Template</title>
  <!-- Favicon icon-->
  <link rel="icon" href="assets/images/favicon.png" type="image/x-icon">
  <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon">
  <!-- Google font-->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
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

  </style>
</head>

<body>
  <!-- tap on top starts-->
  <div class="tap-top"><i class="iconly-Arrow-Up icli"></i></div>
  <!-- tap on tap ends-->
  <!-- loader-->
  <!-- <div class="loader-wrapper">
    <div class="loader"><span></span><span></span><span></span><span></span><span></span></div>
  </div> -->
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
                <h2>Weight calculation
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
                        <a class="card-options-collapse" href="#" data-bs-toggle="card-collapse"><i
                            class="fe fe-chevron-up"></i></a>
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
                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="form-label">Name of the Supplier</label>
                            <select class="form-select" id="supplier" name="supplier" required>
                              <option value="">Select Supplier</option>
                              <?php
                              $result = mysqli_query($conn, "SELECT id, supplier FROM suppliers");
                              while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='{$row['id']}'>{$row['supplier']}</option>";
                              }
                              ?>
                            </select>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group">
                            <label class="form-label">PVT.Mark</label>
                            <select class="form-select" id="bag_batch" name="bag_batch">
                              <option value="">Select PVT.Mark</option>
                              <?php
                              $result = mysqli_query($conn, "SELECT batch FROM bag_batch");
                              while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='{$row['batch']}'>{$row['batch']}</option>";
                              }
                              ?>
                            </select>
                          </div>
                        </div>

                              <!-- dafdas -->
                              <div class="col-sm-6 col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Rate Per Kg</label>
                                    <input type="number" class="form-control" id="rate_per_kg" name="rate_per_kg" required>
                                </div>
                                </div>

                                <div class="hide-until-rate">
                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group">
                                    <label class="form-label">Add Weight</label>
                                    <div id="bagWeights">
                                        <div class="input-group mb-2 bag-weight">
                                        <span class="input-group-text">Bag 1 Weight</span>
                                        <input type="number" class="form-control bag-weight-input" name="bag_weight[]" required>
                                        <button type="button" class="btn btn-success add-bag" style="display: none;"><i class="fa-solid fa-plus"></i></button>
                                        </div>
                                    </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group">
                                    <label class="form-label">No Of Gunny Bags</label>
                                    <input type="number" class="form-control" id="no_of_bags" name="no_of_bags" readonly>
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
                                    <input type="number" class="form-control" id="gunnies_bag_total" name="gunnies_bag_total" readonly>
                                    </div>
                                </div>

                                <div class="col-sm-6 col-md-6">
                                    <div class="form-group">
                                    <label class="form-label">Total Amount</label>
                                    <input type="number" class="form-control" id="total_amount" name="total_amount" readonly>
                                    </div>
                                </div>
                                </div>

                               <!-- afads -->
                    
                      </div>

                      <div id="response" class="text-success"></div>

                      <div class="card-footer text-center">
                        <input type="hidden" name="id" value="<?php echo $rows['id'] ?>">
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
        $("#loginForm").validate({
          rules: {
            rate_per_kg: {
              required: true,
              digits: true,
              min: 1
            },
            add_weight: {
              required: true,
              digits: true,
              min: 1
            },
            supplier: {
              required: true

            },
            bag_batch: {
              required: true
            }
          },
          messages: {
            rate_per_kg: {
              required: "Please enter rate per kg.",
              digits: "Please enter a valid number.",
              min: "Rate must be at least 1."
            },
            add_weight: {
              required: "Please enter weight.",
              digits: "Please enter a valid number.",
              min: "Weight must be at least 1."
            },
            supplier: {
              required: "Please select  the suplier"

            },

            bag_batch: {
              required: "Please Select PVT Mark"
            }
          },
          submitHandler: function (form) {
            form.submit();
          }
        });

      });
      // Form Calculation ********************************************
      // ***************************************************************
      $(document).ready(function () {
    let bagCount = 1;

    // Initially hide all fields except "Rate Per Kg"
    $(".hide-until-rate").hide();

    // Show fields when "Rate Per Kg" is entered
    $("#rate_per_kg").on("input", function () {
        if ($(this).val().trim() !== "") {
            $(".hide-until-rate").slideDown();
        } else {
            $(".hide-until-rate").slideUp();
        }
    });

    // Function to update calculated fields
    function updateCalculations() {
        let totalWeight = 0;
        let bagInputs = $(".bag-weight-input");

        bagInputs.each(function () {
            let weight = parseFloat($(this).val()) || 0;
            totalWeight += weight;
        });

        let noOfBags = bagInputs.length;
        let ratePerKg = parseFloat($("#rate_per_kg").val()) || 0;
        let gunnyBagCost = parseFloat($("input[name='gunnies_bag_rate']").val()) || 0;

        let netWeight = totalWeight - noOfBags;
        let totalBagsCost = noOfBags * gunnyBagCost;
        let totalAmount = (netWeight * ratePerKg) + totalBagsCost;

        $("#no_of_bags").val(noOfBags);
        $("#grosswt").val(totalWeight.toFixed(2));
        $("#net_weight").val(netWeight.toFixed(2));
        $("#gunnies_bag_total").val(totalBagsCost.toFixed(2));
        $("#total_amount").val(totalAmount.toFixed(2));

        // Ensure only last row has "+" and others have "-"
        $(".add-bag").hide();
        $(".remove-bag").show();
        $(".bag-weight:last .add-bag").show();
        if ($(".bag-weight").length === 1) {
            $(".remove-bag").hide(); // Hide remove button if only one row exists
        }
    }

    // Show the plus button when the first bag weight is entered
    $(document).on("input", ".bag-weight-input", function () {
        $(".add-bag").show();
    });

    // Add bag weight input field
    $("#bagWeights").on("click", ".add-bag", function () {
        bagCount++;
        let bagField = `
            <div class="input-group mb-2 bag-weight">
                <span class="input-group-text">Bag ${bagCount} Weight</span>
                <input type="number" class="form-control bag-weight-input" name="bag_weight[]" required>
                <button type="button" class="btn btn-danger remove-bag"><i class="fa-solid fa-minus"></i></button>
                <button type="button" class="btn btn-success add-bag"><i class="fa-solid fa-plus"></i></button>
            </div>`;
        $("#bagWeights").append(bagField);
        updateCalculations();
    });

    // Remove bag weight input field
    $("#bagWeights").on("click", ".remove-bag", function () {
        $(this).closest(".bag-weight").remove();
        bagCount--;
        updateCalculations();
    });

    // Update calculations when any weight is entered
    $("#bagWeights").on("input", ".bag-weight-input", function () {
        updateCalculations();
    });

    $("#rate_per_kg, input[name='gunnies_bag_rate']").on("input", function () {
        updateCalculations();
    });
});


    </script>

</body>

</html>