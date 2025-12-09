<?php
// Start session
session_start();

// Include the database connection
include_once('db-connect.php');

// Check if the user is logged in by verifying session variables
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  // If user is not logged in or is not an admin, redirect to login page
  header('Location:stock-details.php');
  exit(); // Stop further execution
}

// If user is logged in and has the role of admin, continue execution
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $id = $_POST['id'];  // Get the ID to identify which record to update
    $date = $_POST['date'];
    $supplier_name = $_POST['supplier_name'];
    $location = $_POST['location'];
    $total_no_of_bags = $_POST['total_no_of_bags'];

    // Collecting all the bags and pvt values
    if (isset($_POST['bags']) && isset($_POST['pvt']) && is_array($_POST['bags']) && is_array($_POST['pvt'])) {
        $bags_values = $_POST['bags']; // Array of bags values
        $pvt_values = $_POST['pvt'];  // Array of pvt values

        // Initialize an array to store formatted "bags_pvt" pairs
        $bags_pvt_array = [];

        // Loop through the bags and pvt values to create formatted "bags_pvt" pairs
        for ($i = 0; $i < count($bags_values); $i++) {
            if (!empty($bags_values[$i]) && !empty($pvt_values[$i])) {
                $bags_pvt_array[] = $bags_values[$i] . "_" . $pvt_values[$i];
            }
        }

        // Join the bags_pvt array into a comma-separated string
        $bags_pvt = implode(", ", $bags_pvt_array);
    } else {
        $bags_pvt = ''; // Set to an empty string if no bags or pvt values are provided
    }

    // Sanitize and validate input (important for security)
    $date = mysqli_real_escape_string($conn, $date);
    $supplier_name = mysqli_real_escape_string($conn, $supplier_name);
    $location = mysqli_real_escape_string($conn, $location);
    $total_no_of_bags = (int)$total_no_of_bags;
    $id = (int)$id;  // Ensure the ID is an integer to prevent SQL injection

    // Prepare UPDATE query
    $sql = "UPDATE stock_details 
            SET date = ?, supplier_name = ?, location = ?, bags_pvt = ?, total_no_bags = ? 
            WHERE id = ?";

    // Prepare and bind the statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters: 'ssssis' means string, string, string, string, integer, integer
        $stmt->bind_param("ssssis", $date, $supplier_name, $location, $bags_pvt, $total_no_of_bags, $id);

        // Execute the update query
        if ($stmt->execute()) {
            $_SESSION['message'] = "Stock details updated successfully!";
            $_SESSION['status'] = "success";
        } else {
            $_SESSION['message'] = "Failed to update stock details: " . $stmt->error;
            $_SESSION['status'] = "error";
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = "Error preparing statement: " . $conn->error;
        $_SESSION['status'] = "error";
    }

    // Redirect back to the manage page after processing
    header('Location: stock-details.php');
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
/* General Styling for Buttons */
.add-button, .remove-button {
        padding: 8px 15px;
        margin-top: 10px;
        font-size: 16px;
        cursor: pointer;
        border: 1px solid #007bff;
        background-color: #007bff;
        color: white;
        border-radius: 4px;
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .add-button:hover, .remove-button:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }

    .add-button:focus, .remove-button:focus {
        outline: none;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    /* Remove button custom color */
    .remove-button {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .remove-button:hover {
        background-color: #c82333;
    }

    /* Style for the input-container */
    .input-container {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .input-container input {
        margin-right: 10px;
        padding: 8px;
        font-size: 14px;
        width: 120px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    /* Styling for the overall input section */
    #input-section {
        margin-top: 15px;
    }

    /* Responsive Design for Mobile */
    @media (max-width: 767px) {
        .input-container {
            flex-direction: row;
            align-items: center;
        }

        .input-container input {
            width: 40%; /* Adjust input width to make space for buttons */
            margin-right: 10px;
        }

        .add-button, .remove-button {
            width: 50px; /* Make buttons smaller to fit next to inputs */
            padding: 8px 15px;
            margin-top: 0;
        }

        .card-footer {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .card-footer button {
            width: 100%;
        }
    }

    /* Medium devices (tablet and above) */
    @media (min-width: 768px) {
        .input-container {
            flex-direction: row;
            align-items: center;
        }

        .input-container input {
            width: 45%;
        }

        .add-button, .remove-button {
            width: 80px;
            padding: 8px 15px;
            margin-left: 10px;
        }

        .card-footer button {
            width: auto;
        }
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
 
 
// Ensure 'id' is passed in the request and sanitize it
$weight_id = isset($_REQUEST['id']) ? (int) $_REQUEST['id'] : 0;

// Query to fetch stock details for the given id
$sql = "SELECT * FROM stock_details WHERE id = $weight_id";
$res = mysqli_query($conn, $sql);

if ($res && mysqli_num_rows($res) > 0) {
    $rows = mysqli_fetch_array($res);
    $date = $rows["date"];
    $supplier_name = $rows["supplier_name"];
    $total_no_bags = $rows["total_no_bags"];
    $location = $rows["location"];
    $bags_pvt = $rows["bags_pvt"]; // Format: "10_HVA, 10_HVB, 5_HVC"
    
    // Exploding the bags_pvt data into individual bag count and PVT mark components
    $bags_pvt_array = explode(",", $bags_pvt);

    $bags_array = [];
    $pvt_array = [];
    
    foreach ($bags_pvt_array as $bag_pvt) {
        // Split each "10_HVA" into ["10", "HVA"]
        list($bag_count, $pvt_mark) = explode("_", trim($bag_pvt));
        
        // Store the values into separate arrays
        $bags_array[] = $bag_count;
        $pvt_array[] = $pvt_mark;
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
        <div class="row mx-2 custom-gap">
            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label">Date of Purchase</label>
                    <input type="text" class="form-control" id="date" name="date" value="<?php echo $date; ?>" readonly>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Location</label>
                    <input type="text" class="form-control" id="location" name="location" value="<?php echo $location;?>" required>
                </div>
            </div>            
        </div>

        <div class="row mx-2 custom-gap">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">No of Bags</label>
                    <input type="text" class="form-control" id="no_of_bags" name="no_of_bags" value="<?php echo $total_no_bags ?>" required>
                </div>
            </div>

            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label">Supplier Name</label>
                    <input type="text" class="form-control" id="supplier_name" name="supplier_name" value="<?php echo $supplier_name; ?>" required>
                </div>
            </div>
        </div>

        <!-- Dynamic Bag and PVT Input Fields -->
        <div class="row mx-2 custom-gap">
            <div class="col-sm-12 col-md-6">
                <div id="input-section">
                    <?php
                    // Loop through the bags and pvt arrays to create the inputs
                    for ($i = 0; $i < count($bags_array); $i++) {
                        echo '<div class="input-container">';
                        echo '<input type="text" name="bags[]" value="' . htmlspecialchars($bags_array[$i]) . '" placeholder="No of Bags">';
                        echo '<input type="text" name="pvt[]" value="' . htmlspecialchars($pvt_array[$i]) . '" placeholder="PVT Mark">';
                        echo '<button type="button" class="add-button">+</button>';
                        echo '<button type="button" class="remove-button">-</button>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="row mx-2">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Total No of Bags</label>
                    <input type="text" class="form-control" id="total_no_of_bags" name="total_no_of_bags" value="<?php echo $total_no_bags ?>" readonly>
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
 <?php }?>
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
        window.location.href = "stock-details.php"; // Redirect to the target page
      }
    }, 1000);

    // Close Modal and Redirect Immediately on Button Click
    document.getElementById("closeModal").addEventListener("click", function () {
      clearInterval(interval); // Stop the countdown
      window.location.href = "stock-details.php"; // Redirect to the target page
    });
  }
});

function goBack() {
    window.history.back();
}

    </script>


  </body>
</html>