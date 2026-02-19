<?php
require_once 'inc/functions.php';
$pageTitle = 'Order Success';
require_once 'inc/header.php';
?>

<!-- Success Section -->
<section class="order-success-section section-padding">
    <div class="container">
        <div class="success-message">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h1>Thank You for Your Order!</h1>
            <p class="order-number">Order Number: <strong><?php echo isset($_GET['order']) ? $_GET['order'] : ''; ?></strong></p>
            <p>Your order has been placed successfully. We will contact you shortly for confirmation.</p>
            
            <div class="success-actions">
                <a href="products.php" class="btn-primary">Continue Shopping</a>
                <a href="my-account.php" class="btn-secondary">View Orders</a>
            </div>
        </div>
    </div>
</section>

<?php require_once 'inc/footer.php'; ?>
