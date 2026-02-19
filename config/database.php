<?php
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'ghorer_bazar';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

function isAdmin() {
    return isset($_SESSION['admin_id']) && $_SESSION['admin_id'] > 0;
}

function isLoggedIn() {
    return isset($_SESSION['customer_id']) && $_SESSION['customer_id'] > 0;
}
?>
