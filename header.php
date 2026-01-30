<?php
// Ensure session is started safely
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!-- =====================
     APPLICATION HEADER
     (BODY ONLY – NO META / NO PWA)
===================== -->

<header class="page-header row">

  <div class="logo-wrapper d-flex align-items-center col-auto">
    <a href="index.php">
      <img
        class="light-logo img-fluid"
        src="assets/images/logo/logo-dark.png"
        alt="Mirchi CRM"
        width="100"
      />
      <img
        class="dark-logo img-fluid"
        src="assets/images/logo/logo-dark.png"
        alt="Mirchi CRM"
      />
    </a>

    <a class="close-btn toggle-sidebar" href="javascript:void(0)">
      <svg class="svg-color">
        <use href="assets/svg/iconly-sprite.svg#Category"></use>
      </svg>
    </a>
  </div>

  <div class="page-main-header col">

    <div class="header-left">
      <h4>Welcome to Mirchi CRM Dashboard</h4>
    </div>

    <div class="nav-right">
      <ul class="header-right">

        <li class="profile-nav custom-dropdown">
          <div class="user-wrap">

            <!-- USER IMAGE -->
            <div class="user-img">
              <?php
                $pic = isset($_SESSION['pic']) && $_SESSION['pic'] !== ''
                  ? htmlspecialchars($_SESSION['pic'])
                  : 'default-user.png';

                echo '<img src="uploads/' . $pic . '" alt="User" />';
              ?>
            </div>

            <!-- USER INFO -->
            <div class="user-content">
              <h6>
                <?php echo isset($_SESSION['user']) ? htmlspecialchars($_SESSION['user']) : 'Guest'; ?>
              </h6>
              <p class="mb-0">
                <?php
                  echo (isset($_SESSION['role']) && $_SESSION['role'] === 'admin')
                    ? 'Admin'
                    : 'User';
                ?>
                <i class="fa-solid fa-chevron-down"></i>
              </p>
            </div>

          </div>

          <!-- DROPDOWN MENU -->
          <div class="custom-menu overflow-hidden">
            <ul class="profile-body">

              <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') { ?>

                <li class="d-flex">
                  <svg class="svg-color">
                    <use href="assets/svg/iconly-sprite.svg#Profile"></use>
                  </svg>
                  <a class="ms-2" href="edit-profile.php">My Profile</a>
                </li>

                <li class="d-flex">
                  <svg class="svg-color">
                    <use href="assets/svg/iconly-sprite.svg#Message"></use>
                  </svg>
                  <a class="ms-2" href="change-password.php">Change Password</a>
                </li>

                <li class="d-flex">
                  <svg class="svg-color">
                    <use href="assets/svg/iconly-sprite.svg#Login"></use>
                  </svg>
                  <a class="ms-2" href="logout.php">Log Out</a>
                </li>

              <?php } else { ?>

                <li class="d-flex">
                  <svg class="svg-color">
                    <use href="assets/svg/iconly-sprite.svg#Profile"></use>
                  </svg>
                  <a class="ms-2" href="edit-profile-m.php">My Profile</a>
                </li>

                <li class="d-flex">
                  <svg class="svg-color">
                    <use href="assets/svg/iconly-sprite.svg#Message"></use>
                  </svg>
                  <a class="ms-2" href="change-password-m.php">Change Password</a>
                </li>

                <li class="d-flex">
                  <svg class="svg-color">
                    <use href="assets/svg/iconly-sprite.svg#Login"></use>
                  </svg>
                  <a class="ms-2" href="marchant-logout.php">Log Out</a>
                </li>

              <?php } ?>

            </ul>
          </div>

        </li>

      </ul>
    </div>

  </div>
</header>

<!-- =====================
     END HEADER.PHP
===================== -->
