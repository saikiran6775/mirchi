<?php
// Start session
session_start();

// Include the database connection
include_once('db-connect.php');

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: manage-seller.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the ID of the record being updated
    $id = isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : 0;
    if ($id <= 0) {
        $_SESSION['message'] = "Invalid record ID.";
        $_SESSION['status'] = "error";
        header('Location: manage-seller.php');
        exit();
    }

    // Sanitize POST data
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $farmer_name = mysqli_real_escape_string($conn, $_POST['farmer_name']);
    $farmer_location = mysqli_real_escape_string($conn, $_POST['farmer_location']);
    $buyer_name = mysqli_real_escape_string($conn, $_POST['buyer_name']);
    $pvt_mark = mysqli_real_escape_string($conn, $_POST['bag_batch']);
    $no_of_bags = (int)$_POST['no_of_bags'];
    $gross_weight = (float)$_POST['grosswt'];
    $net_weight = (float)$_POST['net_weight'];
    $total_amount = (float)$_POST['total_amount'];
    $gunny_bag_rate = (float)$_POST['gunnies_bag_rate'];
    $gunny_bag_total = (float)$_POST['gunnies_bag_total'];
    $lot_no = (int)$_POST['lot_no'];
    $rate_per_kg = (float)$_POST['rate_per_kg'];
    $gross_amount = (float)$_POST['grossamount'];
    $commission_per = (float)$_POST['commission_per'];
    $expenditure = (float)$_POST['expenditure'];
    $expenditure_amount = (float)$_POST['expenditure_amount'];
    $total_seller_amount = (float)$_POST['total_seller_amount'];

    // Collect weights from shop_no_1 to shop_no_n
$weights = [];
for ($i = 1; $i <= $no_of_bags; $i++) {
    $key = 'shop_no_' . $i;
    if (isset($_POST[$key]) && trim($_POST[$key]) !== '') {
        $weights[] = mysqli_real_escape_string($conn, $_POST[$key]);
    } else {
        $weights[] = '0'; // default value if empty
    }
}
$weightsStr = implode(",", $weights);

    // Determine user ID
    $user_id = isset($_SESSION['merchant_id']) ? $_SESSION['merchant_id'] : $_SESSION['user_id'];

    // Prepare update query
    $sql = "UPDATE importer_weight SET
                date = '$date',
                farmer_name = '$farmer_name',
                farmer_location = '$farmer_location',
                buyer_name = '$buyer_name',
                bag_batch = '$pvt_mark',
                rate_per_kg = '$rate_per_kg',
                commission_per = '$commission_per',
                expenditure = '$expenditure',
                desire_no_bag = '$lot_no',
                no_of_bags = '$no_of_bags',
                bag_weight = '$weightsStr',
                grosswt = '$gross_weight',
                grossamount = '$gross_amount',
                gunnies_bag_rate = '$gunny_bag_rate',
                net_weight = '$net_weight',
                gunnies_bag_total = '$gunny_bag_total',
                total_amount = '$total_amount',
                commission_amount = '$commission_per',
                expenditure_amount = '$expenditure_amount',
                total_seller_amount = '$total_seller_amount',
                status = 1,
                user_id = '$user_id'
            WHERE id = $id";

    // Execute and handle response
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Weight Calculation updated successfully!";
        $_SESSION['status'] = "success";
    } else {
        $_SESSION['message'] = "Failed to update Weight Calculation: " . $conn->error;
        $_SESSION['status'] = "error";
    }
    $bag_weights = []; // default empty
if ($weight_id > 0) {
    $sql = "SELECT * FROM importer_weight WHERE id = $weight_id";
    $res = mysqli_query($conn, $sql);
    if ($res && mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_array($res);
        $bag_weights = isset($row['bag_weight']) ? explode(',', $row['bag_weight']) : [];
    }
}

    // Redirect
    header('Location: manage-seller.php');
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
$bag_weights = [];

if ($weight_id > 0) {
    $sql = "SELECT * FROM importer_weight WHERE id = $weight_id";
    $res = mysqli_query($conn, $sql);

    if ($res && mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_array($res);

        $date = $row["date"];
        $pvt_mark = $row["bag_batch"];
        $farmer_name = $row["farmer_name"];
        $farmer_location = $row["farmer_location"];
        $no_of_bags = $row["no_of_bags"];
        $gross_weight = $row["grosswt"];
        $net_weight = $row["net_weight"];
        $total_amount = $row["total_amount"];
        $gunny_bag_rate = $row["gunnies_bag_rate"];
        $gunny_bag_total = $row["gunnies_bag_total"];
        $rate_per_kg = $row["rate_per_kg"];
        $lot_no = $row["desire_no_bag"];
        $commission_per = $row["commission_per"];
        $commission_amount = $row["commission_amount"];
        $expenditure = $row["expenditure"];
        $expenditure_amount = $row["expenditure_amount"];
        $buyer_name = $row["buyer_name"];
        $total_seller_amount = $row["total_seller_amount"];
        $bag_weights = isset($row['bag_weight']) ? explode(',', $row['bag_weight']) : [];
    }
}
?>

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
            <input type="text" class="form-control" id="date" name="date" value="<?php echo $date;?>" readonly>
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label class="form-label">Farmer Name</label>
            <input type="text" class="form-control" id="farmer_name" name="farmer_name" value="<?php echo $farmer_name;?>">
          </div>
        </div>                 
      </div>
      
      <div class="row mx-4 custom-gap">
        <div class="col-md-6">
          <div class="form-group">
            <label class="form-label">Farmer Location</label>
            <input type="text" class="form-control" id="farmer_location" name="farmer_location" value="<?php echo $farmer_location;?>" required>
          </div>
        </div>

        <div class="col-sm-6 col-md-6">
          <div class="form-group">
            <label class="form-label">Buyer Name</label>
            <input type="text" class="form-control" id="buyer_name" name="buyer_name" value="<?php echo $buyer_name;?>" required>
          </div>
        </div>
      </div>

      <div class="row mx-4 custom-gap">
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

      <div class="row mx-4 custom-gap">
        <div class="col-sm-6 col-md-6">
          <div class="form-group">
            <label class="form-label">Commission Percentage</label>
            <input type="number" class="form-control" id="commission_per" name="commission_per" value="<?php echo $commission_per;?>" >
          </div>
        </div>

        <div class="col-sm-6 col-md-6">
          <div class="form-group">
            <label class="form-label">Expenditure</label>
            <input type="number" class="form-control" id="expenditure" name="expenditure" value="<?php echo $expenditure;?>">
          </div>
        </div>
      </div>

      <div class="row mx-4 custom-gap">
        <div class="col-sm-6 col-md-6">
          <div class="form-group">
            <label class="form-label">Lot Number</label>
            <input type="text" name="lot_no" class="form-control" id="lot_no" value="<?php echo $lot_no;?>" oninput="handleKeyPress(this)">
            <div id="lotNoMessage" class="mt-2"></div> 
          </div>
        </div>

        <div class="col-sm-6 col-md-6">
          <div class="form-group">
            <label class="form-label">No Of Gunny Bags</label>
            <input type="text" class="form-control" id="no_of_bags" name="no_of_bags" value="<?php echo $no_of_bags;?>" oninput="handleKeyPress(this)">
          </div>
        </div>
      </div>

       <div class="row text-center">
            <label class="form-label">Enter Weights</label>
            <div id="weights-calculation" class="weights-caluculation mx-4 mb-5"></div>
        </div> 
      <!--<div id="weights-calculation" class="row weights-calculation mx-4 mb-5"></div>-->

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
            <label class="form-label">Net Weight</label>
            <input type="number" class="form-control" id="net_weight" name="net_weight" value="<?php echo $net_weight; ?>" readonly>
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
            <label class="form-label">Total Seller Amount</label>
            <input type="number" class="form-control" id="total_seller_amount" name="total_seller_amount" value="<?php echo $total_seller_amount;?>">
          </div>
        </div>
      </div>

      <div class="row mx-4 custom-gap">
        <div class="col-sm-6 col-md-6">
          <div class="form-group">
            <label class="form-label">Commission Amount</label>
            <input type="number" class="form-control" id="commission_amount" name="commission_amount" value="<?php echo $commission_amount;?>" readonly>
          </div>
        </div>

        <div class="col-sm-6 col-md-6">
          <div class="form-group">
            <label class="form-label">Expenditure Amount</label>
            <input type="number" class="form-control" id="expenditure_amount" name="expenditure_amount" value="<?php echo $expenditure_amount;?>" readonly>
          </div>
        </div>
      </div>

      <div class="row mx-4 custom-gap">
        <div class="col-sm-6 col-md-6">
             <div class="form-group">
            <label class="form-label">Total Weight Amount</label>
            <input type="number" class="form-control" id="total_amount" name="total_amount" value="<?php echo $total_amount;?>" readonly>
          </div>
        </div>
      </div>

      <div id="response" class="text-success"></div>
      <div class="card-footer text-center">
        <input type="hidden" name="id" value="<?php echo $weight_id; ?>">
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
    <!-- <script src="assets/js/theme-customizer/customizer.js"></script> -->
    <!-- custom script -->
    <script src="assets/js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<script>
$(document).ready(function () {
    const bagWeights = <?php echo json_encode($bag_weights); ?>;

    function generateBagFields() {
        const container = $("#weights-calculation");
        container.empty();

        const numBags = parseInt($("#no_of_bags").val()) || 0;

        for (let i = 1; i <= numBags; i++) {
            const input = $("<input>", {
                type: "number",
                class: "form-control custom-weight mb-2 bag-weight-input",
                id: "shop_no_" + i,
                name: "shop_no_" + i,
                placeholder: "Bag " + i,
                value: bagWeights[i - 1] || ""
            });

            input.on("input", performCalculations);
            container.append(input);
        }

        setupValidation();
    }

    function performCalculations() {
        let totalWeight = 0;
        $(".bag-weight-input").each(function () {
            const weight = parseFloat($(this).val()) || 0;
            totalWeight += weight;
        });

        const numBags = $(".bag-weight-input").length;
        const ratePerKg = parseFloat($('#rate_per_kg').val()) || 0;
        const gunnyRate = parseFloat($('#gunnies_bag_rate').val()) || 0;
        const commissionPer = parseFloat($('#commission_per').val()) || 0;
        const expenditure = parseFloat($('#expenditure').val()) || 0;
        
    const netWeight = totalWeight - numBags;
    const grossAmount = totalWeight * ratePerKg;
    const totalBagsCost = numBags * gunnyBagCost;
    const totalAmount = netWeight * ratePerKg;
    const commissionAmount = (totalAmount * commissionPer / 100);
    const expenditureAmount = expenditure * numBags;
    const totalSellerAmount = totalAmount - commissionAmount - expenditureAmount;

        $('#grosswt').val(totalWeight.toFixed(2));
        $('#gross_amount').val(grossAmount.toFixed(2));
        $('#net_weight').val(netWeight.toFixed(2));
        $('#gunnies_bag_total').val(gunnyCost.toFixed(2));
        $('#total_amount').val(totalAmount.toFixed(2));
        $('#commission_amount').val(commissionAmount.toFixed(2));
        $('#expenditure_amount').val(expenditureAmount.toFixed(2));
        $('#total_seller_amount').val(totalSellerAmount.toFixed(2));
    }

    function getShopNumberValidationRules() {
        let rules = {};
        let numBags = parseInt($('#no_of_bags').val()) || 0;
        for (let i = 1; i <= numBags; i++) {
            rules["shop_no_" + i] = { required: true };
        }
        return rules;
    }

    function getShopNumberMessages() {
        let messages = {};
        let numBags = parseInt($('#no_of_bags').val()) || 0;
        for (let i = 1; i <= numBags; i++) {
            messages["shop_no_" + i] = {
                required: "Please enter weight for Bag " + i
            };
        }
        return messages;
    }

    function setupValidation() {
        if ($('#loginForm').data('validator')) {
            $('#loginForm').validate().destroy();
        }

        $('#loginForm').validate({
            rules: {
                no_of_bags: { required: true, min: 1 },
                rate_per_kg: { required: true, number: true, min: 0.01 },
                lot_no: { required: true, digits: true, min: 1 },
                bag_batch: { required: true },
                supplier: { required: true },
                ...getShopNumberValidationRules()
            },
            messages: {
                no_of_bags: { required: "Please enter number of bags", min: "At least 1" },
                rate_per_kg: { required: "Enter rate", number: "Must be number", min: "Positive only" },
                lot_no: { required: "Enter lot", digits: "Digits only", min: "At least 1" },
                bag_batch: { required: "Enter PVT Mark" },
                supplier: { required: "Select supplier" },
                ...getShopNumberMessages()
            },
            errorPlacement: function (error, element) {
                error.appendTo(element.closest('.form-group'));
            },
            submitHandler: function (form) {
                form.submit();
            }
        });
    }

    // Trigger on page load and when bag count changes
    generateBagFields();
    performCalculations();

    $('#no_of_bags').on('input', generateBagFields);
    $('#rate_per_kg, #commission_per, #expenditure').on('input', performCalculations);
});
    function goBack() {
    window.history.back();
  }
</script>






  </body>
</html>