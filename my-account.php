<?php
require_once 'inc/functions.php';
$pageTitle = 'My Account';
require_once 'inc/header.php';

if(!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$customer = getCustomerById($_SESSION['customer_id']);
$orders = getCustomerOrders($_SESSION['customer_id']);
?>

<!-- Page Banner -->
<section class="page-banner">
    <div class="container">
        <h1>My Account</h1>
        <p><a href="index.php">Home</a> / My Account</p>
    </div>
</section>

<!-- My Account Section -->
<section class="my-account-section section-padding">
    <div class="container">
        <div class="account-layout">
            <aside class="account-sidebar">
                <div class="user-info">
                    <div class="user-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <h3><?php echo $customer['name']; ?></h3>
                    <p><?php echo $customer['email']; ?></p>
                </div>
                
                <ul class="account-menu">
                    <li><a href="#orders" class="active"><i class="fas fa-shopping-bag"></i> My Orders</a></li>
                    <li><a href="#profile"><i class="fas fa-user"></i> Profile</a></li>
                    <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </aside>
            
            <div class="account-content">
                <div class="content-section" id="orders">
                    <h3>My Orders</h3>
                    
                    <?php if(empty($orders)): ?>
                    <p>No orders yet.</p>
                    <a href="products.php" class="btn-primary">Start Shopping</a>
                    <?php else: ?>
                    <div class="orders-list">
                        <?php foreach($orders as $order): ?>
                        <div class="order-card">
                            <div class="order-header">
                                <span class="order-number">Order #<?php echo $order['order_number']; ?></span>
                                <span class="order-status <?php echo $order['order_status']; ?>"><?php echo ucfirst($order['order_status']); ?></span>
                            </div>
                            <div class="order-details">
                                <p>Date: <?php echo date('d M Y, g:i A', strtotime($order['created_at'])); ?></p>
                                <p>Total: <?php echo formatPrice($order['total']); ?></p>
                                <p>Items: <?php 
                                    $items = getOrderItems($order['id']);
                                    echo count($items);
                                ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
                
                <div class="content-section" id="profile" style="display:none;">
                    <h3>Profile Information</h3>
                    <form method="POST" action="">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="name" value="<?php echo $customer['name']; ?>">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" value="<?php echo $customer['email']; ?>" disabled>
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="tel" name="phone" value="<?php echo $customer['phone']; ?>">
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="address"><?php echo $customer['address']; ?></textarea>
                        </div>
                        <button type="submit" class="btn-primary">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'inc/footer.php'; ?>
