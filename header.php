<!— BEGIN HEADER.PHP —>

<!-- PWA Manifest -->
<link rel="manifest" href="/manifest.json">

<!-- PWA Icons -->
<link rel="apple-touch-icon" href="/assets/images/icon-192.png">
<link rel="icon" sizes="192x192" href="/assets/images/icon-192.png">
<link rel="icon" sizes="512x512" href="/assets/images/icon-512.png">

<!-- PWA Meta Tags -->
<meta name="theme-color" content="#0a0a0a" />
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">

<!-- Register Service Worker -->
<script>
if ("serviceWorker" in navigator) {
  window.addEventListener("load", () => {
    navigator.serviceWorker.register("/sw.js")
      .catch(err => console.log("SW registration failed:", err));
  });
}
</script>

<header class="page-header row">
    <div class="logo-wrapper d-flex align-items-center col-auto">
        <a href="index.php">
            <img class="light-logo img-fluid" src="assets/images/logo/logo-dark.png" alt="logo" width="100"/>
            <img class="dark-logo img-fluid" src="assets/images/logo/logo-dark.png" alt="logo"/>
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

                  <div class="user-img">
                      <?php 
                      if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
                          echo '<img src="uploads/' . htmlspecialchars($_SESSION['pic']) . '" alt="user"/>';
                      } else {
                          echo '<img src="uploads/' . htmlspecialchars($_SESSION['pic']) . '" alt="user"/>';
                      }
                      ?>
                  </div>

                  <div class="user-content">
                    <h6><?php echo htmlspecialchars($_SESSION['user']); ?></h6>
                    <p class="mb-0">
                      <?php 
                        echo (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') ? 'Admin' : 'User';
                      ?>
                      <i class="fa-solid fa-chevron-down"></i>
                    </p>
                  </div>
                </div>

                <div class="custom-menu overflow-hidden">
                  <ul class="profile-body">

                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { ?>
                    
                    <li class="d-flex"> 
                      <svg class="svg-color"><use href="assets/svg/iconly-sprite.svg#Profile"></use></svg>
                      <a class="ms-2" href="edit-profile.php">My Profile</a>
                    </li>

                    <li class="d-flex"> 
                      <svg class="svg-color"><use href="assets/svg/iconly-sprite.svg#Message"></use></svg>
                      <a class="ms-2" href="change-password.php">Change Password</a>
                    </li>

                    <li class="d-flex"> 
                      <svg class="svg-color"><use href="assets/svg/iconly-sprite.svg#Login"></use></svg>
                      <a class="ms-2" href="logout.php">Log Out</a>
                    </li>

                    <?php } else { ?>

                    <li class="d-flex"> 
                      <svg class="svg-color"><use href="assets/svg/iconly-sprite.svg#Profile"></use></svg>
                      <a class="ms-2" href="edit-profile-m.php">My Profile</a>
                    </li>

                    <li class="d-flex"> 
                      <svg class="svg-color"><use href="assets/svg/iconly-sprite.svg#Message"></use></svg>
                      <a class="ms-2" href="change-password-m.php">Change Password</a>
                    </li>

                    <li class="d-flex"> 
                      <svg class="svg-color"><use href="assets/svg/iconly-sprite.svg#Login"></use></svg>
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

<!— END HEADER.PHP —>
