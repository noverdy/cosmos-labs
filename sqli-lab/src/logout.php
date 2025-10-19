<?php
require_once 'config.php';

// Log logout if user was logged in
if (isLoggedIn()) {
    $user_id = $_SESSION['user_id'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $log_query = "INSERT INTO audit_log (user_id, action, description, ip_address) VALUES
                 ($user_id, 'LOGOUT', 'User logged out', '$ip')";
    $conn->query($log_query);
}

// Destroy session
session_destroy();

// Redirect to login page
redirect('login.php');
?>