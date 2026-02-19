<?php
$conn = new mysqli('127.0.0.1', 'root', '');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error . "\n");
}

$conn->query("CREATE DATABASE IF NOT EXISTS ghorer_bazar");
$conn->select_db('ghorer_bazar');

$sql = file_get_contents('../database.sql');

if ($conn->multi_query($sql)) {
    echo "Database imported successfully!\n";
} else {
    echo "Error: " . $conn->error . "\n";
}

$conn->close();
?>
