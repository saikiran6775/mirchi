<?php
session_start();

// Check the user's role in the session
if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') {
    // If the user is an admin, redirect to login.php
    header('Location: login.php');
} 

// Destroy the session (logout the user)
session_destroy();
exit();
?>
