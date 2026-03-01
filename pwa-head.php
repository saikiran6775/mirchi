<link rel="manifest" href="manifest.json">

<link rel="icon" sizes="192x192" href="assets/images/icon-192.png">
<link rel="icon" sizes="512x512" href="assets/images/icon-512.png">
<link rel="apple-touch-icon" href="assets/images/icon-192.png">

<meta name="theme-color" content="#0a0a0a">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">

<script>
if ('serviceWorker' in navigator) {
  window.addEventListener('load', () => {
    navigator.serviceWorker.register('sw.js');
  });
}
</script>
