<?php
session_start();
require_once '../inc/functions.php';

$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
$change = isset($_POST['change']) ? intval($_POST['change']) : 0;

if($product_id > 0 && isset($_SESSION['cart'][$product_id])) {
    $_SESSION['cart'][$product_id] += $change;
    
    if($_SESSION['cart'][$product_id] < 1) {
        unset($_SESSION['cart'][$product_id]);
    }
}

echo json_encode(['success' => true]);
?>
