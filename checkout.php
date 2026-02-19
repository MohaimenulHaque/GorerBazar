<?php
require_once 'inc/functions.php';
$pageTitle = 'Checkout';
require_once 'inc/header.php';

$cartItems = getCartItems();

if(empty($cartItems)) {
    // header('Location: cart.php');
    ?>
    <script>
        window.location.href = 'cart.php';
    </script>
    <?php
    exit;
}

$error = '';
$success = '';

if(isset($_POST['place_order'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $payment_method = $_POST['payment_method'];
    $notes = $_POST['notes'] ?? '';
    
    if(empty($name) || empty($phone) || empty($address) || empty($city)) {
        $error = 'Please fill in all required fields';
    } else {
        $customer_id = isLoggedIn() ? $_SESSION['customer_id'] : null;
        
        $shipping_info = [
            'name' => $name,
            'phone' => $phone,
            'address' => $address,
            'city' => $city,
            'payment_method' => $payment_method,
            'notes' => $notes
        ];
        
        $order_number = saveOrder($customer_id, $cartItems, $shipping_info);
        
        if($order_number) {
            // header('Location: order-success.php?order=' . $order_number);
            // $success = 'Order placed successfully!';
            // exit;
            ?>
            <script>
                window.location.href = 'index.php?order_success=<?php echo $order_number; ?>';
            </script>
            <?php
        } else {
            $error = 'Failed to place order. Please try again.';
        }
    }
}
?>

<!-- Page Banner -->
<section class="page-banner">
    <div class="container">
        <h1>Checkout</h1>
        <p><a href="index.php">Home</a> / Checkout</p>
    </div>
</section>

<!-- Checkout Section -->
<section class="checkout-section section-padding">
    <div class="container">
        <?php if($error): ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
        <div class="checkout-layout">
            <div class="checkout-form">
                <div class="form-section">
                    <h3>Shipping Information</h3>
                    
                    <?php if(!isLoggedIn()): ?>
                    <div class="login-prompt">
                        <p>Already have an account? <a href="login.php?redirect=checkout">Login here</a></p>
                    </div>
                    <?php endif; ?>
                    
                    <div class="form-group">
                        <label>Full Name *</label>
                        <input type="text" name="name" required value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label>Phone Number *</label>
                        <input type="tel" name="phone" required value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label>Address *</label>
                        <textarea name="address" required><?php echo isset($_POST['address']) ? $_POST['address'] : ''; ?></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label>City *</label>
                        <input type="text" name="city" required value="<?php echo isset($_POST['city']) ? $_POST['city'] : ''; ?>">
                    </div>
                    
                    <div class="form-group">
                        <label>Order Notes (Optional)</label>
                        <textarea name="notes"><?php echo isset($_POST['notes']) ? $_POST['notes'] : ''; ?></textarea>
                    </div>
                </div>
                
                <div class="form-section">
                    <h3>Payment Method</h3>
                    
                    <div class="payment-options">
                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="cod" checked>
                            <div class="payment-card">
                                <i class="fas fa-money-bill-wave"></i>
                                <span>Cash on Delivery</span>
                            </div>
                        </label>
                        
                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="bkash">
                            <div class="payment-card">
                                <i class="fas fa-mobile-alt"></i>
                                <span>bKash</span>
                            </div>
                        </label>
                        
                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="nagad">
                            <div class="payment-card">
                                <i class="fas fa-wallet"></i>
                                <span>Nagad</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="order-summary">
                <h3>Order Summary</h3>
                
                <div class="summary-items">
                    <?php foreach($cartItems as $item): ?>
                    <div class="summary-item">
                        <img src="images/products/<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" onerror="this.src='https://via.placeholder.com/50x50?text=Product'">
                        <div>
                            <h4><?php echo $item['name']; ?></h4>
                            <p>Qty: <?php echo $item['quantity']; ?></p>
                        </div>
                        <span><?php echo formatPrice($item['item_total']); ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="summary-totals">
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span><?php echo formatPrice(getCartTotal()); ?></span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping</span>
                        <span><?php echo formatPrice(getSetting('shipping_cost')); ?></span>
                    </div>
                    <div class="summary-row total">
                        <span>Total</span>
                        <span><?php echo formatPrice(getCartTotal() + floatval(getSetting('shipping_cost'))); ?></span>
                    </div>
                </div>
                
                <button type="submit" name="place_order" class="btn-primary place-order-btn">
                    Place Order
                </button>
            </div>
        </div>
        </form>
    </div>
</section>

<?php require_once 'inc/footer.php'; ?>
