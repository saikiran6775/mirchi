<aside class="page-sidebar">
    <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
    <div class="main-sidebar" id="main-sidebar">
        <ul class="sidebar-menu" id="simple-bar">
            <li class="pin-title sidebar-main-title">
                <div>
                    <h5 class="sidebar-title f-w-700">Pinned</h5>
                </div>
            </li>
            <li class="sidebar-list"><i class="fa-solid fa-thumbtack"></i><a class="sidebar-link" href="index.php">
                    <svg class="stroke-icon">
                        <use href="assets/svg/iconly-sprite.svg#Home-dashboard"></use>
                    </svg>
                    <h6>Dashboards</h6>
                </a>

            </li>

             <?php if ($_SESSION['role'] === 'admin') { ?>
            <li class="sidebar-list"> <i class="fa-solid fa-thumbtack"></i><a class="sidebar-link"
                    href="manage-merchants.php">
                    <svg class="stroke-icon">
                        <use href="../assets/svg/iconly-sprite.svg#Profile"></use>
                    </svg>
                    <h6 class="f-w-600">Manage Merchants</h6>
                </a>
            </li>
             <li class="sidebar-list"> <i class="fa-solid fa-thumbtack"></i><a class="sidebar-link"
                    href="merchant-support.php">
                    <svg class="stroke-icon">
                        <use href="../assets/svg/iconly-sprite.svg#Tick-square"></use>
                    </svg>
                    <h6 class="f-w-600">Inbox</h6>
                </a></li>
                <?php
             }else{
                ?>
                 <li class="sidebar-list"> <i class="fa-solid fa-thumbtack"></i><a class="sidebar-link"
                    href="manage-employees.php">
                    <svg class="stroke-icon">
                        <use href="../assets/svg/iconly-sprite.svg#Profile"></use>
                    </svg>
                    <h6 class="f-w-600">Manage Employees</h6>
                </a>
            </li>
            <li class="sidebar-list"><i class="fa-solid fa-thumbtack"></i><a class="sidebar-link" href="make-purchase.php">
                  <svg class="stroke-icon">
                    <use href="../assets/svg/iconly-sprite.svg#Paper-plus"></use>
                  </svg>
                  <h6 class="f-w-600">Make Purchase</h6></a></li>
                   <li class="sidebar-list"> <i class="fa-solid fa-thumbtack"></i><a class="sidebar-link" href="manage-supplier.php">
                  <svg class="stroke-icon">
                    <use href="../assets/svg/iconly-sprite.svg#Bookmark"></use>
                  </svg>
                  <h6 class="f-w-600">Manage Supplier</h6></a></li>
                  <li class="sidebar-list"> <i class="fa-solid fa-thumbtack"></i><a class="sidebar-link" href="manage-mirchi-type.php">
                  <svg class="stroke-icon">
                    <use href="../assets/svg/iconly-sprite.svg#Tick-square"></use>
                  </svg>
                  <h6 class="f-w-600">Manage Mirchi Type</h6></a></li>
            <?php
             }
            ?>
            <li class="sidebar-list"> <i class="fa-solid fa-thumbtack"></i><a class="sidebar-link"
                    href="logout.php">
                    <svg class="stroke-icon">
                        <use href="../assets/svg/iconly-sprite.svg#Search-sidebar"></use>
                    </svg>
                    <h6 class="f-w-600">Logout</h6>
                </a></li>
               
        </ul>
    </div>
    <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
</aside>