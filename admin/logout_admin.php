<?php
session_start();
$_SESSION = array();
// Destroy the session
session_destroy();

// Redirect to the login page (or any other page after logout)
header("Location: admin.php");
exit;
?>