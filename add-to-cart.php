<?php
session_start();
require_once 'inc/functions.php';

if(isset($_POST['add_to_cart'])) {
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);
    
    if($product_id > 0) {
        addToCart($product_id, $quantity);
        $_SESSION['cart_message'] = 'Product added to cart!';
    }
}

$redirect = $_SERVER['HTTP_REFERER'] ?? 'index.php';
if(strpos($redirect, '?') !== false) {
    $redirect .= '&msg=added';
} else {
    $redirect .= '?msg=added';
}

header('Location: ' . $redirect);
exit;
?>
