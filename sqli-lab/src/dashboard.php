<?php
require_once 'config.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

$current_user = getCurrentUser();

if ($current_user['role'] === 'admin') {
    redirect('admin_dashboard.php');
} else {
    redirect('student_dashboard.php');
}
?>