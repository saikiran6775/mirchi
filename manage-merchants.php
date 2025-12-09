<?php
// Start session
session_start();

// Store last visited URL
$_SESSION['last_page'] = $_SERVER['REQUEST_URI'];

// Database connection
include_once('db-connect.php');

// Check user authentication
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header('Location: login.php');
    exit();
}

// Handle Delete (BEFORE SELECT)
if (isset($_GET['mode']) && $_GET['mode'] === 'delete') {
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($id > 0) {
        $sql = "UPDATE merchants SET status='inactive' WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $id);
            mysqli_stmt_execute($stmt);

            if (mysqli_stmt_affected_rows($stmt) > 0) {
                $_SESSION['success_message'] = "Merchant deleted successfully!";
                $_SESSION['flash_color'] = "#052c65";
            } else {
                $_SESSION['success_message'] = "No matching merchant found or already inactive.";
                $_SESSION['flash_color'] = "orange";
            }

            mysqli_stmt_close($stmt);
        } else {
            $_SESSION['success_message'] = "Database error: Could not prepare delete.";
            $_SESSION['flash_color'] = "red";
        }
    } else {
        $_SESSION['success_message'] = "Invalid merchant ID.";
        $_SESSION['flash_color'] = "red";
    }

    header("Location: manage-merchants.php");
    exit();
}

// Search filter
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Pagination setup
$limit = 6;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Count total merchants (ONLY active)
$total_query = "SELECT COUNT(*) as total FROM merchants WHERE option = '1' AND status = 'active' 
                AND (name LIKE '%$search%' OR email LIKE '%$search%' OR address LIKE '%$search%')";
$total_result = $conn->query($total_query);
$total_row = $total_result->fetch_assoc();
$total_profiles = $total_row['total'];
$total_pages = ceil($total_profiles / $limit);

// Fetch active merchants with filter
$sql = "SELECT * FROM merchants WHERE option = '1' AND status = 'active' 
        AND (name LIKE '%$search%' OR email LIKE '%$search%' OR address LIKE '%$search%') 
        LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Mirchi CRM Admin Panel" />
    <meta name="keywords" content="Mirchi CRM Admin Panel" />
    <meta name="author" content="Mirchi CRM" />
    <title>Mirchi CRM - Premium Admin Template</title>
    <!-- Favicon icon-->
    <link rel="icon" href="assets/images/favicon.png" type="image/x-icon" />
    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon" />
    <!-- Google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="" />
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito+Sans:opsz,wght@6..12,200;6..12,300;6..12,400;6..12,500;6..12,600;6..12,700;6..12,800;6..12,900;6..12,1000&amp;display=swap"
        rel="stylesheet" />
    <!-- Flag icon css -->
    <link rel="stylesheet" href="assets/css/vendors/flag-icon.css" />
    <!-- iconly-icon-->
    <link rel="stylesheet" href="assets/css/iconly-icon.css" />
    <link rel="stylesheet" href="assets/css/bulk-style.css" />
    <!-- iconly-icon-->
    <link rel="stylesheet" href="assets/css/themify.css" />
    <!--fontawesome-->
    <link rel="stylesheet" href="assets/css/fontawesome-min.css" />
    <!-- Whether Icon css-->
    <link rel="stylesheet" type="text/css" href="assets/css/vendors/weather-icons/weather-icons.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/vendors/scrollbar.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/vendors/slick.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/vendors/slick-theme.css" />
    <!-- App css -->
    <link rel="stylesheet" href="assets/css/style.css" />
    <link id="color" rel="stylesheet" href="assets/css/color-1.css" media="screen" />
    <style>
       .pagination {
        display: flex;
        justify-content: center; /* Centers pagination */
        align-items: center;
        margin: 10px;
    }
        .pagination a {
            padding: 10px 15px;
            text-decoration: none;
            color: #333;
            border: 1px solid #ccc;
            margin: 0 5px;
            border-radius: 5px;
        }
        .pagination a.active {
            background-color: #007bff;
            color: white;
            border: 1px solid #007bff;
        }
        .pagination a:hover {
            background-color: #ddd;
        }
    </style>
</head>

<body>
    <!-- page-wrapper Start-->
    <!-- tap on top starts-->
    <div class="tap-top"><i class="iconly-Arrow-Up icli"></i></div>
    <!-- tap on tap ends-->
    <!-- loader-->
    <div class="loader-wrapper">
        <div class="loader"><span></span><span></span><span></span><span></span><span></span></div>
    </div>
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <!-- Page header -->
        <?php
        // Include the header file to load the common header section of the webpage
        // This helps in maintaining a consistent layout across multiple pages
        include 'header.php';
        ?>

        <!-- Page Body Start-->
        <div class="page-body-wrapper">
            <!-- Page sidebar start-->
            <?php
            // Include the sidebar file to display the navigation menu or additional content
            // This ensures consistency across multiple pages
            include 'sidebar.php';
            ?>
            <!-- Page sidebar end-->
            <div class="page-body">
                <div class="container-fluid">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-sm-6 col-12">
                                <h2>Manage Merchants</h2>
                            </div>
                            <div class="col-sm-6 col-12">
                                 <div class="m-3">
                                    <button type="button" class="btn btn-success btn-icon-text btn-sm "
                                        style="float:right; padding:5px;" onclick="location.href='manage-merchant-profile.php?mode=add'">
                                    <i class="icon-plus"></i>
                                         Add Merchant
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Merchant Cards -->
                    <div class="card">
                        <div class="row m-3">
                           <div class="mx-auto">
                                   <form method="GET" action="" class="row mb-3">
                                <!-- Search input taking 3/4 of the width -->
                                <div class="col-md-5 col-md-offset-1">
                                    <input type="text" name="search" id="searchMerchant" class="form-control" value="<?php echo $search; ?>" placeholder="Search by Name, Email, or Address">
                                </div>
                                
                                <!-- Hidden submit button taking 1/4 of the width -->
                                <div class="col-md-3 col-md-offset-1">
                                    <button type="submit" class="btn btn-success btn-icon-text btn-sm" style="padding:5px; ">Submit</button>
                                </div>
                           </div>
                            </form>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <div class="col-xl-4 col-sm-6 col-xxl-3 col-ed-4 box-col-4">
                                    <div class="card social-profile">
                                        <div class="card-body">
                                            <div class="social-img-wrap">
                                                <div class="social-img">
                                                    <img class="img-fluid" src="<?php echo $row['profile_image'] ?: 'upload/3.jpg'; ?>" alt="profile" width="70"/>
                                                </div>
                                            </div>
                                            <div class="social-details">
                                                <h5 class="mb-1"><?php echo $row['name']; ?></h5>
                                                <span class="f-light">@<?php echo $row['username']; ?></span>
                                                <p class="small"><?php echo $row['mobile']; ?></p>
                                                <p class="small">📍 <?php echo $row['address']; ?></p>
                                                <ul class="social-follow">
                                                    <li>
                                                        <h6>Status: <span style="color:<?php echo ($row['status'] == 'active') ? 'green' : 'red'; ?>">
                                                            <?php echo ucfirst($row['status']); ?>
                                                        </span></h6>
                                                    </li>
                                                    <li>
                                                        <h6>Validity: <?php echo $row['validity']; ?></h6>
                                                    </li>
                                                    <li>
                                                         <ul class="action"> 
                                                            <li class="edit"> <a href="manage-merchant-profile.php?mode=edit&id=<?php echo $row['id'];?>"><i class="icon-pencil-alt"></i></a></li>
                                                         <a href="manage-merchants.php?mode=delete&id=<?php echo (int)$row['id']; ?>"
   onclick="return confirm('Are you sure you want to delete this record?');">
   <i class="icon-trash"></i>
</a>

                                                        </ul>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>
                <!-- Pagination -->
                <!-- Pagination -->
                    <div class="pagination">
                        <?php if ($page > 1): ?>
                            <a href="?page=<?php echo $page - 1; ?>&search=<?php echo $search; ?>" class="prev">Previous</a>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <a href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>" class="<?php echo ($i == $page) ? 'active' : ''; ?>"><?php echo $i; ?></a>
                        <?php endfor; ?>

                        <?php if ($page < $total_pages): ?>
                            <a href="?page=<?php echo $page + 1; ?>&search=<?php echo $search; ?>" class="next">Next</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <!-- Page Footer -->
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
    <!-- feather-->
    <script src="assets/js/vendors/feather-icon/feather.min.js"></script>
    <script src="assets/js/vendors/feather-icon/custom-script.js"></script>
    <!-- sidebar -->
    <script src="assets/js/sidebar.js"></script>
    <!-- scrollbar-->
    <script src="assets/js/scrollbar/simplebar.js"></script>
    <script src="assets/js/scrollbar/custom.js"></script>
    <!-- slick-->
    <script src="assets/js/slick/slick.min.js"></script>
    <script src="assets/js/slick/slick.js"></script>
    <!-- theme_customizer-->
    <script src="assets/js/theme-customizer/customizer.js"></script>
    <!-- custom script -->
    <script src="assets/js/script.js"></script>
        <!-- Search Filtering Script -->
    <script>
       document.getElementById('searchMerchant').addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault(); // Prevent form from submitting the default way
            this.form.submit(); // Submit the form manually
        }
    });
        $(document).ready(function () {
            $("#searchMerchant").on("keyup", function () {
                let searchText = $(this).val().toLowerCase();

                $(".merchant-card").each(function () {
                    let name = $(this).data("name").toLowerCase();
                    let email = $(this).data("email").toLowerCase();
                    let address = $(this).data("address").toLowerCase();

                    // Check if any field contains the search text
                    if (name.includes(searchText) || email.includes(searchText) || address.includes(searchText)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
    </script>
</body>

</html>