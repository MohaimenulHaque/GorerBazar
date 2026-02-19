<?php
session_start();
require_once '../inc/functions.php';

$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;

if($product_id > 0) {
    removeFromCart($product_id);
}

echo json_encode(['success' => true]);
?>
