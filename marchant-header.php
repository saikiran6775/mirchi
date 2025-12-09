<header class="page-header row">
    <div class="logo-wrapper d-flex align-items-center col-auto"><a href="index.php">
            <img class="light-logo img-fluid" src="assets/images/logo/logo-dark.png" alt="logo" width="100" />
            <img class="dark-logo img-fluid" src="assets/images/logo/logo-dark.png" alt="logo" /></a>
        <a class="close-btn toggle-sidebar" href="javascript:void(0)">
            <svg class="svg-color">
                <use href="assets/svg/iconly-sprite.svg#Category"></use>
            </svg></a>
    </div>
    <div class="page-main-header col">
        <div class="header-left">
            <h4>Welcome to Mirchi CRM Dashboard</h4>

        </div>
        <div class="nav-right">
            <ul class="header-right">
                <li class="profile-nav custom-dropdown">
                    <div class="user-wrap">
                        <div class="user-img">
                            <?php
                            if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
                                // If the user is an admin, show the admin's image
                                echo '<img src="uploads/' . htmlspecialchars($_SESSION['pic']) . '" alt="user"/>';
                            } else {
                                // If the user has no role or is not an admin, show a default image
                                echo '<img src="' . htmlspecialchars($_SESSION['pic']) . '" alt="user"/>';

                            }
                            ?>
                        </div>

                        <div class="user-content">
                            <h6>
                                <?php echo htmlspecialchars($_SESSION['user']); ?>
                            </h6>
                            <!--<p class="mb-0">Admin<i class="fa-solid fa-chevron-down"></i></p>-->
                            <p class="mb-0">
                                <?php
                                // Check the role and display corresponding text
                                if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
                                    echo 'Admin';  // Admin user
                                } else {
                                    echo 'User';  // Non-admin user
                                }
                                ?>
                                <i class="fa-solid fa-chevron-down"></i>
                            </p>
                        </div>
                    </div>
                    <div class="custom-menu overflow-hidden">
                        <ul class="profile-body">


                            <li class="d-flex">
                                <svg class="svg-color">
                                    <use href="assets/svg/iconly-sprite.svg#Profile"></use>
                                </svg><a class="ms-2" href="edit-profile-m.php">My Profile</a>
                            </li>
                            <li class="d-flex">
                                <svg class="svg-color">
                                    <use href="assets/svg/iconly-sprite.svg#Message"></use>
                                </svg><a class="ms-2" href="change-password-m.php">Change Password</a>
                            </li>
                            <li class="d-flex">
                                <svg class="svg-color">
                                    <use href="assets/svg/iconly-sprite.svg#Login"></use>
                                </svg><a class="ms-2" href="marchant-logout.php">Log Out</a>
                            </li>




                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</header>