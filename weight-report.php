<?php
session_start(); // Start the session to store success/error messages
include_once('db-connect.php'); // Include the database connection

// Check if the user is logged in, if not, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header('Location: marchant-login.php');
    exit(); // Stop further execution
}

// Determine the user_id to use
if ($_SESSION['user_id'] == $_SESSION['merchant_id']) {
    $user_id = $_SESSION['user_id'];  // Use user_id if they are equal
} else {
    $user_id = $_SESSION['merchant_id'];  // Use merchant_id if they are different
}

// Prepare the SQL query using a placeholder for user_id
$query = "SELECT id, date, supplier, no_of_bags, net_weight, total_amount, lot_no, pvt_mark 
          FROM weight 
          WHERE status = 1 AND user_id = ?";

// Prepare the statement
$stmt = $conn->prepare($query);

// Bind the user_id parameter to the statement
$stmt->bind_param("i", $user_id); // 'i' for integer (user_id is assumed to be an integer)

// Execute the query
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Initialize an array to store supplier data
$supplier = [];

// Check if the query returned any rows
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $supplier[] = $row;
    }
}

// Close the statement and connection
$stmt->close();


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Manage Activites">
    <meta name="keywords" content="Manage Activites">
    <meta name="author" content="kbk software solutions">
    <link rel="icon" href="assets/images/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon">
    <title>Manage Activites</title>
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
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<!-- DataTables JavaScript -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<!-- Your custom script.js -->
<!--<script src="script.js"></script>-->
<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
<!-- DataTables Buttons CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.3.3/css/buttons.dataTables.min.css">

    <style>
        .btn-toggle{
            display:none;
        }
        .form-select{
            font-size:12px !important;
        }
       .form-control{
            font-size:12px !important;
        }
        .pvt{
            padding-top:5px;
        }
        .dt-buttons {
   margin-left:10px;
}
        .buttons-copy{
            background-color:#308e87;
        }
       @media (max-width: 767px) {
        .email-tabs {
            display: block;
        }

        .nav-item {
            width: 100%;
            margin-bottom: 10px;
        }

        .form-select,
        .form-control {
            width: 100%;
        }

        .btn {
            width: 100%;
        }

        .table-responsive {
            overflow-x: auto;
        }
    }

    .table th, .table td {
        text-align: center;
    }
    </style>
  </head>
  <body> 
    <!-- loader starts-->
    <div class="loader-wrapper">
      <div class="loader"> 
        <div class="loader4"></div>
      </div>
    </div>
    <!-- loader ends-->
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
      <!-- Page Header Start-->
      <?php
    // Include the header file to load the common header section of the webpage
    // This helps in maintaining a consistent layout across multiple pages
    include 'marchant-header.php';
    ?>
      <!-- Page Header Ends                              -->
      <!-- Page Body Start-->
      <div class="page-body-wrapper">
        <!-- Page Sidebar Start-->
       <?php include "marchant-sidebar.php";?>
        <!-- Page Sidebar Ends-->
        <div class="page-body">
          <!-- Container-fluid starts-->
          <div class="container-fluid">
            <div class="row">
              <!-- Zero Configuration  Starts-->
              <div class="col-sm-12">
               <div class="card mt-5">
    <div class="card-body">
        <div class="card-header bg-primary mb-3 text-center">
            <h4>Weight calculation Reports</h4>
        </div>

        <!-- Filter Form -->
        <form id="filterForm">
            <div class="form-check form-check-inline mb-3">
                <ul class="email-tabs nav" role="tablist">
                    <!-- Supplier Select -->
  <li class="nav-item mx-2">
                <select class="form-select digits" id="supplier" name="supplier">
                    <option value="">Select Supplier</option>
                    <?php 
                      // Ensure user_id and merchant_id are set
                      if ($_SESSION['user_id'] == $_SESSION['merchant_id']) {
                        $user_id = $_SESSION['user_id'];  // Use user_id if they are equal
                    } else {
                        $user_id = $_SESSION['merchant_id'];  // Use merchant_id if they are different
                    }
                $query = "SELECT DISTINCT supplier 
                FROM weight 
                WHERE status = 1 
                AND user_id = '$user_id'";
                    $result = mysqli_query($conn, "SELECT id, supplier FROM suppliers WHERE status=1 AND user_id = $user_id");
                   while ($row = mysqli_fetch_assoc($result)) {
    $selected = ($row['id'] == $supplier_id) ? 'selected' : ''; 
    echo "<option value='{$row['id']}' {$selected}>{$row['supplier']}</option>";
}?>
                </select>
            </li>
                    
                    <!-- Month Select -->
                    <li class="nav-item mx-2 mt-1">Month:</li>
                    <li class="nav-item mx-2">
                        <input class="form-control digits w-100" type="month" id="month" name="month">
                    </li>

                    <!-- Start Date -->
                    <li class="nav-item mx-2 mt-1">Start Date:</li>
                    <li class="nav-item mx-2">
                        <input class="form-control digits w-100" type="date" id="startdate" name="startdate">
                    </li>

                    <!-- End Date -->
                    <li class="nav-item mx-2 mt-1">End Date:</li>
                    <li class="nav-item mx-2">
                        <input class="form-control digits w-100" type="date" id="enddate" name="enddate">
                    </li>

                    <!-- PVT Mark -->
                    <li class="nav-item mx-2 mt-1">PVT Mark:</li>
                    <li class="nav-item mx-2">
                        <input class="form-control digits pvt w-100" type="text" id="pvt_mark" name="pvt_mark">
                    </li>

                    <!-- Submit Button -->
                    <li class="nav-item mx-2 mt-2">
                        <button class="btn btn-primary w-100" type="submit" title="Search">Search</button>
                    </li>
                </ul>
            </div>
        </form>

        <!-- DataTable -->
        <div class="table-responsive">
            <table id="weightreport" class="display table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Date</th>
                         <th>Supplier</th>
                         <th>PVT mark</th>
                          <th>Lot No</th>
                        <th>No of Bags</th>
                        <th>Net Weight</th>
                        <th>Total Amount</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

              </div>
              <!-- Zero Configuration  Ends-->
            </div>
          </div>
          <!-- Container-fluid Ends-->
        </div>
        <!-- footer start-->
       <?php include "footer.php";?>
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
  <!-- theme_customizer-->
  <!--<script src="assets/js/theme-customizer/customizer.js"></script>-->
  <!-- custom script -->
  <script src="assets/js/script.js"></script> 
<!-- jQuery (Required for DataTables) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTable JS Libraries (Ensure these are loaded in correct order) -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

<!-- jsPDF Libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>

<!-- xlsx (for Excel exports) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

<!-- jQuery Validation (Form validation) -->
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>

<!-- Custom Scripts -->
<!--<script src="assets/js/form-validations-activites.js"></script>-->
<!--<script src="assets/js/bootstrap/bootstrap.bundle.min.js"></script>-->

<!-- Your custom script (ensure it's loaded once) -->
<!--<script src="scripts.js"></script>-->
<script>
$(document).ready(function() {
    var table = $('#weightreport').DataTable({
        "ajax": {
            "url": "fetch-weight-calculation.php",
            "type": "POST",
            "data": function(d) {
                var form = $('#filterForm');
                var formData = form.serializeArray();
                $.each(formData, function(i, field) {
                    d[field.name] = field.value;
                });
            },
            "dataSrc": "data",
            "error": function(xhr, error, thrown) {
                console.log('Error:', thrown);
            }
        },
        "columns": [
            {
                "data": null, // no data for this column, will render the serial number
                "render": function (data, type, row, meta) {
                    return meta.row + 1; // Serial number starts from 1
                }
            },
               { "data": "date" },
               { "data": "supplier_name" },
               { "data": "pvt_mark" },
               { "data": "lot_no" },
               { "data": "no_of_bags" },
               { "data": "net_weight" },
               { "data": "total_amount" }
           
           
        ],
        "order": [[1, 'asc']], // Default sorting by first column
        "dom": 'Bfrtip', // Add Buttons to DataTables
        "buttons": [
            {
                extend: 'copyHtml5',
                className: 'btn-copy',
                text: 'Copy'
            },
            {
                extend: 'excelHtml5',
                className: 'btn-excel',
                text: 'Excel'
            },
            {
                extend: 'pdfHtml5',
                className: 'btn-pdf',
                text: 'PDF'
            },
            {
                extend: 'print',
                className: 'btn-print',
                text: 'Print'
            }
        ],
        "rowCallback": function(row, data, index) {
            // This will update the serial number dynamically
            $('td', row).eq(0).html(index + 1); // Serial number in the first column
        }
    });

    // Submit form and reload table data
    $('#filterForm').on('submit', function(e) {
        e.preventDefault(); // Prevent default form submission
        table.ajax.reload(); // Reload the table data with the new filters
    });
});


</script>
  </body>
</html>