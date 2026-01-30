<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="manifest" href="/mirchi-main/manifest.json">

<link rel="icon" sizes="192x192" href="/mirchi-main/assets/images/icon-192.png">
<link rel="icon" sizes="512x512" href="/mirchi-main/assets/images/icon-512.png">
<link rel="apple-touch-icon" href="/mirchi-main/assets/images/icon-192.png">

<meta name="theme-color" content="#0a0a0a">
<meta name="mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-capable" content="yes">

<script>
if ('serviceWorker' in navigator) {
  window.addEventListener('load', () => {
    navigator.serviceWorker.register('/mirchi-main/sw.js');
  });
}
</script>
