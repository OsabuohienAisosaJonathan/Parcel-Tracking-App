<?php
session_start();
require_once 'handler/logger.php';
session_unset();     // Clear all session variables
session_destroy();   // Destroy the session
// Redirect to the login page
header("Location: ../admin_log.php"); 
exit();
