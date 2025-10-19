<?php
define('DB_HOST', 'xss-db');
define('DB_NAME', 'news_app');
define('DB_USER', 'newsuser');
define('DB_PASS', 'newspass');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>