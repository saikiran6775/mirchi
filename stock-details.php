<?php
session_start(); // Start the session to store success/error messages
include_once('db-connect.php'); // Include the database connection
// Check if the user is logged in by verifying session variables
if (!isset($_SESSION['user_id'])) {
    // If user is not logged in, redirect to login page
    header('Location: marchant-login.php');
    exit(); // Stop further execution
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    session_start(); // Ensure sessions are started

    // Get form data
    $date = $_POST['date'];
    $supplier_name = $_POST['supplier_name'];
    $total_no_of_bags = $_POST['total_no_of_bags'];
    $location = $_POST['location'];

    // Process bags and pvt values
    $bags_pvt = '';
    if (isset($_POST['bags']) && isset($_POST['pvt']) && is_array($_POST['bags']) && is_array($_POST['pvt'])) {
        $bags_values = $_POST['bags'];
        $pvt_values = $_POST['pvt'];
        $bags_pvt_array = [];

        for ($i = 0; $i < count($bags_values); $i++) {
            if (!empty($bags_values[$i]) && !empty($pvt_values[$i])) {
                $bags_pvt_array[] = $bags_values[$i] . "_" . $pvt_values[$i];
            }
        }
        $bags_pvt = implode(", ", $bags_pvt_array);
    }

    // Sanitize inputs
    $date = mysqli_real_escape_string($conn, $date);
    $supplier_name = mysqli_real_escape_string($conn, $supplier_name);
    $location = mysqli_real_escape_string($conn, $location);
    $total_no_of_bags = (int)$total_no_of_bags;

    // Validate session user_id
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['merchant_id'])) {
        die("Error: Session variables not set properly.");
    }

    $user_id = ($_SESSION['user_id'] == $_SESSION['merchant_id']) ? $_SESSION['user_id'] : $_SESSION['merchant_id'];

    // INSERT query
    $sql = "INSERT INTO stock_details (date, supplier_name, location, bags_pvt, total_no_bags, user_id, status) 
            VALUES (?, ?, ?, ?, ?, ?, 1)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssssii", $date, $supplier_name, $location, $bags_pvt, $total_no_of_bags, $user_id);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Stock details added successfully!";
            $_SESSION['status'] = "success";

            // Force redirection
            header("Location: stock-details.php", true, 303);
            exit();
        } else {
            die("Error executing insert: " . $stmt->error);
        }
    } else {
        die("Error preparing statement: " . $conn->error);
    }
}

    

if (isset($_GET['hid']) && $_GET['hid'] == 'delete' && isset($_GET['id'])) {
    // Ensure ID is a valid integer
    $id = intval($_GET['id']); 
    
    // Debugging line (you can remove this after confirming it works)
    // echo $id; 
    
    if ($id > 0) { // Check if ID is a valid positive integer
        // Prepare the SQL statement for soft delete
        $delete_sql = "UPDATE stock_details SET status = 0 WHERE id = ?";
        
        if ($stmt = mysqli_prepare($conn, $delete_sql)) {
            // Bind the parameters
            mysqli_stmt_bind_param($stmt, "i", $id);
  
            // Execute the statement
            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['message'] = "Stock details deactivated successfully!";
                $_SESSION['status'] = "success";
                header('Location: stock-details.php');
                exit();
            } else {
                $_SESSION['message'] = "Failed to deactivate Stock details .";
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
    header('Location: stock-details.php');
    exit();}




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
.pvt{
    margin-bottom:5px;
}
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
                <h2>Stock Details</h2>
              </div>
              <div class="col-sm-6 col-12">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index-m.php"></a></li>
                  <li class="breadcrumb-item active">Stock Details</li>
                </ol>
              </div>
            </div>
            <div class="row">
             <div>


<?php
// Determine which user_id to use based on session
if ($_SESSION['user_id'] == $_SESSION['merchant_id']) {
    $user_id = $_SESSION['user_id'];  // Use user_id if they are equal
} else {
    $user_id = $_SESSION['merchant_id'];  // Use merchant_id if they are different
}

// Prepare the SQL query to fetch both sums
$sql = "SELECT 
            (SELECT SUM(total_no_bags) FROM stock_details WHERE status = '1' AND date = CURDATE() AND user_id = ?) AS total_bags_sum,
            (SELECT SUM(no_of_bags) FROM importer_weight WHERE status = '1' AND user_id = ?) AS no_bags_sum";

// Prepare and execute the query
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("ii", $user_id, $user_id);  // 'i' for integer (user_id is expected to be an integer)
    
    if ($stmt->execute()) {
        // Bind the result to variables
        $stmt->bind_result($total_bags_sum, $no_bags_sum);
        
        // Fetch the result
        if ($stmt->fetch()) {
            // Display the results
            $total_bags_sum = $total_bags_sum ? $total_bags_sum : 0;
            $no_bags_sum = $no_bags_sum ? $no_bags_sum : 0;
            
            // echo "Total number of bags from stock_details: " . $total_bags_sum . "<br>";
            // echo "Total number of bags from weight table: " . $no_bags_sum . "<br>";

            // Calculate the number of bags left
            $bags_left = $total_bags_sum - $no_bags_sum;
            echo "Number of Bags left: " . $bags_left . "<br>";
        } else {
            echo "No records found for today.";
        }
    } else {
        echo "Error executing query: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Error preparing query: " . $conn->error;
}
?></div>
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
                          onclick="location.href='stock-details.php?mode=add'">
                          <i class="icon-plus"></i> Add Stock Details
                        </button>
                      </div>
                      <table class="display" id="basic-1">
                                <thead>
                                <tr>
                                    <th>Sl.No</th>
                                    <th>Location</th>
                                    <th>Supplier name</th>
                                    <th> Total No of bags</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
           if ($_SESSION['user_id'] == $_SESSION['merchant_id']) {
            $user_id = $_SESSION['user_id'];  // Use user_id if they are equal
        } else {
            $user_id = $_SESSION['merchant_id'];  // Use merchant_id if they are different
        }
        
        // Prepare the SQL query with placeholders to prevent SQL injection
        $sql = "SELECT * 
                FROM stock_details                       
                WHERE status = '1' 
                AND date = CURDATE() 
                AND user_id = ?";
        
        // Prepare the statement
        $stmt = $conn->prepare($sql);
        
        // Check if prepare() was successful
        if ($stmt === false) {
            die('MySQL prepare error: ' . $conn->error); // Output error if failed
        }
        
        // Bind the parameter to the prepared statement
        $stmt->bind_param('i', $user_id);  // 'i' is for integer (user_id is assumed to be an integer)
        
        // Execute the statement
        if (!$stmt->execute()) {
            die('MySQL execute error: ' . $stmt->error); // Output error if execute fails
        }
        
        // Get the result
        $result = $stmt->get_result();
        
        // Initialize counter for rows
        $i = 0;
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $i++; 

                                        ?>
                                        <tr>

                                            <td><?php echo $i;?></td>
                                            <td><?php echo $row["location"]; ?></td>
                                            <td><?php echo $row["supplier_name"]; ?></td>
                                            <td><?php echo $row["total_no_bags"]; ?></td>
                                            <td> 
                                                <ul class="action"> 
                                                <li class="preview mx-2"><a href="preview-stock-details.php?id=<?php echo urlencode($row['id']); ?>"><i class="fa-regular fa-eye"></i></a></li>
                                                    <li class="edit"><a href="edit-stock-details.php?id=<?php echo urlencode($row['id']); ?>"><i class="icon-pencil-alt"></i></a></li>
                                                    <li class="delete"><a
                                        href="stock-details.php?hid=delete&id=<?php echo $row['id']; ?>"
                                        onclick="return confirm('Are you sure you want to delete this record?');">
                                        <i class="icon-trash"></i></a>
                                    </li>

                                                </ul>
                                            </td>
                                        </tr>
                                        <?php 
                                            }
                                        
                               
                                        ?>
                                </tbody>
                              </table>
 
                    </div>
                    <?php
                 } } else {
                    ?>
                                  <?php
                              
                                  

 $date="";

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
        <div class="row mx-2 custom-gap">
            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label">Date of Purchase</label>
                    <input type="text" class="form-control" id="date" name="date" value="<?php echo ($_REQUEST['mode'] == 'edit') ? $date : date('Y-m-d'); ?>" readonly>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Location</label>
                    <input type="text" class="form-control" id="location" name="location" required>
                </div>
            </div>            
        </div>

        <div class="row mx-2 custom-gap">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">No of Bags</label>
                    <input type="text" class="form-control" id="no_of_bags" name="no_of_bags" required>
                </div>
            </div>

            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label">Supplier Name</label>
                    <input type="text" class="form-control" id="supplier_name" name="supplier_name" required>
                </div>
            </div>
        </div>

        <div class="row mx-2 custom-gap">
            <div class="col-sm-12 col-md-6">
                <div id="input-section">
                    <div class="input-container">
                        <input type="text" name="bags[]" placeholder="No of Bags">
                        <input type="text" name="pvt[]" placeholder="PVT Mark">
                        <button type="button" class="add-button">+</button>
                        <button type="button" class="remove-button">-</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mx-2">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">Total No of Bags</label>
                    <input type="text" class="form-control" id="total_no_of_bags" name="total_no_of_bags" readonly>
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

  <!-- Load jQuery first -->
<script src="assets/js/vendors/jquery/jquery.min.js"></script>
<script src="assets/js/theme-customizer/customizer.js"></script>
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
   // Function to update the total number of bags
  // Update total number of bags based on the input
function updateTotalBags() {
    let totalBags = 0;
    // Get all the bags input fields
    let bagsFields = document.querySelectorAll('input[name="bags[]"]');
    
    // Sum up the values in the bags fields
    bagsFields.forEach(function(bagField) {
        let value = parseInt(bagField.value);
        if (!isNaN(value)) {
            totalBags += value;
        }
    });

    // Display the total number of bags
    document.getElementById('total_no_of_bags').value = totalBags;
}

// Add event listener to the "Add" button
document.getElementById('input-section').addEventListener('click', function(event) {
    if (event.target.classList.contains('add-button')) {
        let inputSection = document.getElementById('input-section');
        let newInputContainer = document.createElement('div');
        newInputContainer.classList.add('input-container');
        
        let bags = document.createElement('input');
        bags.type = 'text';
        bags.name = 'bags[]'; // Ensure this is an array
        bags.placeholder = 'Enter no of bags';
        
        let pvt = document.createElement('input');
        pvt.type = 'text';
        pvt.name = 'pvt[]'; // Ensure this is an array
        pvt.placeholder = 'Enter PVT Mark';
        
        let addButton = document.createElement('button');
        addButton.type = 'button';
        addButton.classList.add('add-button');
        addButton.innerText = '+';
        
        let removeButton = document.createElement('button');
        removeButton.type = 'button';
        removeButton.classList.add('remove-button');
        removeButton.innerText = '-';
        
        newInputContainer.appendChild(bags);
        newInputContainer.appendChild(pvt);
        newInputContainer.appendChild(addButton);
        newInputContainer.appendChild(removeButton);
        
        inputSection.appendChild(newInputContainer);
        
        updateTotalBags();
    }
    
    // Remove the field if the remove button is clicked
    if (event.target.classList.contains('remove-button')) {
        let inputContainer = event.target.closest('.input-container');
        if (inputContainer) {
            inputContainer.remove();
            updateTotalBags();
        }
    }
});

// Listen for input changes to update the total number of bags
document.getElementById('input-section').addEventListener('input', function() {
    updateTotalBags();
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
// Go back function
function goBack() {
    window.history.back();
}
// 



</script>
</body>

</html>