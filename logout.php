<?php
// No need to call session_start() here since it's already called in index.php
// Check if we're already in an active session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Clear all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to login page (using a safer alternative to header)
echo "<script>window.location.href = 'login.php';</script>";
exit;
?>