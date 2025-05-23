<?php

if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    $_SESSION['last_activity'] = time(); // refresh session
    echo "OK";
} else {
    http_response_code(403);
    echo "Session expired";
}

// Auto-logout time limit (in seconds)
$timeout_duration = 1800; // 30 minutes

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: ../admin_log.php");
    exit();
}

// Check for session timeout
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
    session_unset();
    session_destroy();
    header("Location: ../admin_log.php?timeout=1");
    exit();
}

// Update last activity time
$_SESSION['last_activity'] = time();

?>