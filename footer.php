<!-- BEGIN FOOTER.PHP -->

<footer class="footer"> 
  <div class="container-fluid">
    <div class="row"> 
      <div class="col-md-6 footer-copyright">
        <p class="mb-0">Copyright 2024 © KBK Software Solutions.</p>
      </div>
      <div class="col-md-6">
        <p class="float-end mb-0">Mirchi CRM
          <svg class="svg-color footer-icon">
            <use href="assets/svg/iconly-sprite.svg#heart"></use>
          </svg>
        </p>
      </div>
    </div>
  </div>
</footer>

<!-- PWA Install Button -->
<div id="installBox" 
     style="position: fixed; bottom: 20px; right: 20px; z-index: 99999; display:none;">
  <button id="installButton" 
    style="padding: 12px 18px; background:#ff9800; border:none; color:#fff;
           border-radius:6px; font-weight:bold; cursor:pointer;">
    📲 Install App
  </button>
</div>

<!-- PWA Install Handler -->
<script>
let deferredPrompt;
const installBox = document.getElementById("installBox");
const installButton = document.getElementById("installButton");

// Hide by default
installBox.style.display = "none";

// Trigger when PWA installable
window.addEventListener("beforeinstallprompt", (e) => {
  e.preventDefault();
  deferredPrompt = e;

  // Show install button
  installBox.style.display = "block";
});

// Install handler
installButton.addEventListener("click", async () => {
  installBox.style.display = "none";
  deferredPrompt.prompt();

  const result = await deferredPrompt.userChoice;

  if (result.outcome === "accepted") {
    console.log("PWA Installed");
  }

  deferredPrompt = null;
});
</script>

<!-- DO NOT register service worker here.
     Registration is already done in header.php -->

<!-- END FOOTER.PHP -->
