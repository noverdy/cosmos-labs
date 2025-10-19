<?php
define('DB_HOST', 'sqli-db');
define('DB_NAME', 'cosmos_apps');
define('DB_USER', 'cosmosuser');
define('DB_PASS', 'cosmospass');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

session_start();

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function getCurrentUser() {
    if (isLoggedIn()) {
        global $conn;
        $user_id = $_SESSION['user_id'];
        $query = "SELECT * FROM users WHERE id = $user_id";
        $result = $conn->query($query);
        return $result->fetch_assoc();
    }
    return null;
}

function redirect($url) {
    header("Location: $url");
    exit();
}

function sanitize($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>