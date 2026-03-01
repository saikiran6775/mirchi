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

if (installBox && installButton) {
  const isStandalone = window.matchMedia("(display-mode: standalone)").matches || window.navigator.standalone;
  installBox.style.display = isStandalone ? "none" : "block";

  // Detect install availability.
  window.addEventListener("beforeinstallprompt", (e) => {
    e.preventDefault();
    deferredPrompt = e;
    installBox.style.display = "block";
  });

  // Hide once installed.
  window.addEventListener("appinstalled", () => {
    installBox.style.display = "none";
    deferredPrompt = null;
  });

  // Install app on button click.
  installButton.addEventListener("click", async () => {
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

    installBox.style.display = "none";
    deferredPrompt.prompt();

    await deferredPrompt.userChoice;
    deferredPrompt = null;
  });
}
</script>

<!-- END FOOTER.PHP -->
