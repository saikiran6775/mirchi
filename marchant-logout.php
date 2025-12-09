<?php
session_start();
// Destroy all session variables
$_SESSION = [];

// Unset and destroy the session
session_unset();
session_destroy();

// Redirect to login page after logout
header("Location: marchant-login.php");
exit();
?>
