<?php
session_start();
include 'db-connect.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mirchi CRM – Login</title>

  <!-- ✅ PWA HEAD -->
  <?php include 'pwa-head.php'; ?>

  <!-- CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="login-bg">

<div class="container-fluid">
  <div class="row">
    <div class="col-xl-5 login_two_image"></div>
    <div class="col-xl-7 p-0">
      <div class="login-card login-dark">
        <div class="login-main">
          <form method="POST">
            <h2 class="text-center">Sign in to account</h2>

            <div class="form-group">
              <label>Email</label>
              <input class="form-control" type="email" name="email" required>
            </div>

            <div class="form-group">
              <label>Password</label>
              <input class="form-control" type="password" name="password" required>
            </div>

            <button class="btn btn-primary w-100 mt-3">Sign In</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- INSTALL BUTTON -->
<div id="installBox"
  style="position:fixed;bottom:20px;right:20px;z-index:9999;display:none;">
  <button id="installBtn"
    style="padding:12px 18px;background:#ff9800;color:#fff;border:none;border-radius:6px;">
    📲 Install App
  </button>
</div>

<script>
let deferredPrompt;
const box = document.getElementById('installBox');
const btn = document.getElementById('installBtn');

if (box && btn) {
  const isStandalone = window.matchMedia("(display-mode: standalone)").matches || window.navigator.standalone;
  box.style.display = isStandalone ? 'none' : 'block';

  window.addEventListener('beforeinstallprompt', (e) => {
    e.preventDefault();
    deferredPrompt = e;
    box.style.display = 'block';
  });

  window.addEventListener('appinstalled', () => {
    box.style.display = 'none';
    deferredPrompt = null;
  });

  btn.addEventListener('click', async () => {
    if (!deferredPrompt) {
      const isIos = /iphone|ipad|ipod/i.test(window.navigator.userAgent);
      if (isIos) {
        alert("On iPhone/iPad: tap Share and choose 'Add to Home Screen'.");
      } else if (!window.isSecureContext) {
        alert("Install requires HTTPS (or localhost). Open this app on a secure URL.");
      } else {
        alert("Install prompt is not available yet. Browse the app for a few seconds and try again.");
      }
      return;
    }

    box.style.display = 'none';
    deferredPrompt.prompt();
    await deferredPrompt.userChoice;
    deferredPrompt = null;
  });
}
</script>

</body>
</html>
