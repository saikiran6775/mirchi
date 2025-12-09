<?php 
// Start the session to store success/error messages
include_once('db-connect.php'); // Include the database connection
?>

<aside class="page-sidebar">
    <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
    <div class="main-sidebar" id="main-sidebar">
        <ul class="sidebar-menu" id="simple-bar">
            <li class="pin-title sidebar-main-title">
                <div>
                    <h5 class="sidebar-title f-w-700">Pinned</h5>
                </div>
            </li>
            <li class="sidebar-list"><i class="fa-solid fa-thumbtack"></i><a class="sidebar-link" href="marchant-dashboard.php">
                <svg class="stroke-icon">
                    <use href="assets/svg/iconly-sprite.svg#Home-dashboard"></use>
                </svg>
                <h6>Dashboards</h6>
            </a></li>

            <?php if ($_SESSION['role'] == 'admin') { ?>
                <li class="sidebar-list"><i class="fa-solid fa-thumbtack"></i><a class="sidebar-link" href="manage-employees.php">
                    <svg class="stroke-icon">
                        <use href="../assets/svg/iconly-sprite.svg#Profile"></use>
                    </svg>
                    <h6 class="f-w-600">Manage Employees</h6>
                </a></li>
            <?php } ?>

            <?php if ($_SESSION['purpose'] == 'export') { ?>
                <li class="sidebar-list"><i class="fa-solid fa-thumbtack"></i><a class="sidebar-link" href="daily-report.php">
                    <svg class="stroke-icon">
                        <use href="../assets/svg/iconly-sprite.svg#Profile"></use>
                    </svg>
                    <h6 class="f-w-600">Daily Report</h6>
                </a></li>

                <li class="sidebar-list"><i class="fa-solid fa-thumbtack"></i><a class="sidebar-link" href="weight-report.php">
                    <svg class="stroke-icon">
                        <use href="../assets/svg/iconly-sprite.svg#Paper-plus"></use>
                    </svg>
                    <h6 class="f-w-600">Weight Calculation Report</h6>
                </a></li>

                <li class="sidebar-list"><i class="fa-solid fa-thumbtack"></i><a class="sidebar-link" href="weight-calculation.php">
                    <svg class="stroke-icon">
                        <use href="../assets/svg/iconly-sprite.svg#Paper-plus"></use>
                    </svg>
                    <h6 class="f-w-600">Weight Calculation</h6>
                </a></li>

                <li class="sidebar-list"><i class="fa-solid fa-thumbtack"></i><a class="sidebar-link" href="javascript:void(0)"> 
                    <svg class="stroke-icon">
                        <use href="../assets/svg/iconly-sprite.svg#Home-dashboard"></use>
                    </svg>
                    <h6>Master Data</h6><span class="badge"></span><i class="iconly-Arrow-Right-2 icli"></i>
                </a>
                    <ul class="sidebar-submenu">
                        <li><a href="manage-suppliers.php">Manage Supplier</a></li>
                        <li><a href="gunny-bag-cost.php">Manage Gunny Bag Price</a></li>
                    </ul>
                </li>
            <?php } ?>

            <?php if ($_SESSION['purpose'] == 'import') { ?>
                <li class="sidebar-list"><i class="fa-solid fa-thumbtack"></i><a class="sidebar-link" href="manage-seller.php">
                    <svg class="stroke-icon">
                        <use href="../assets/svg/iconly-sprite.svg#Paper-plus"></use>
                    </svg>
                    <h6 class="f-w-600">Manage Importer Weight Calculation</h6>
                </a></li>
                <li class="sidebar-list"><i class="fa-solid fa-thumbtack"></i><a class="sidebar-link" href="manage-stock.php">
                    <svg class="stroke-icon">
                        <use href="../assets/svg/iconly-sprite.svg#Paper-plus"></use>
                    </svg>
                    <h6 class="f-w-600">Stock</h6>
                </a></li>
                  <li class="sidebar-list"><i class="fa-solid fa-thumbtack"></i><a class="sidebar-link" href="manage-sales.php">
                    <svg class="stroke-icon">
                        <use href="../assets/svg/iconly-sprite.svg#Paper-plus"></use>
                    </svg>
                    <h6 class="f-w-600">Sales</h6>
                </a></li>
                <li class="sidebar-list"><i class="fa-solid fa-thumbtack"></i><a class="sidebar-link" href="javascript:void(0)"> 
                    <svg class="stroke-icon">
                        <use href="../assets/svg/iconly-sprite.svg#Home-dashboard"></use>
                    </svg>
                    <h6>Master Data</h6><span class="badge"></span><i class="iconly-Arrow-Right-2 icli"></i>
                </a>
                    <ul class="sidebar-submenu">
                        <li><a href="stock-details.php">Manage Stock Detail</a></li>
                        <li><a href="gunny-bag-cost.php">Manage Gunny Bag Price</a></li>
                    </ul>
                </li>
            <?php } ?>

            <li class="sidebar-list"><i class="fa-solid fa-thumbtack"></i><a class="sidebar-link" href="marchant-logout.php">
                <svg class="stroke-icon">
                    <use href="../assets/svg/iconly-sprite.svg#Search-sidebar"></use>
                </svg>
                <h6 class="f-w-600">Logout</h6>
            </a></li>
        </ul>
    </div>
    <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
</aside>
