<?php
session_start();
require_once '../inc/functions.php';

$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
$quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

if($product_id > 0) {
    addToCart($product_id, $quantity);
    echo json_encode(['success' => true, 'cart_count' => getCartCount()]);
} else {
    echo json_encode(['success' => false]);
}
?>
