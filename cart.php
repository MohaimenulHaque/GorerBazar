<?php
require_once 'inc/functions.php';
$pageTitle = 'Shopping Cart';
require_once 'inc/header.php';

// Handle cart actions
if(isset($_POST['update_qty'])) {
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);
    
    if($quantity > 0) {
        $_SESSION['cart'][$product_id] = $quantity;
    } else {
        unset($_SESSION['cart'][$product_id]);
    }
}

if(isset($_POST['remove_item'])) {
    $product_id = intval($_POST['product_id']);
    if(isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }
}

if(isset($_POST['clear_cart'])) {
    unset($_SESSION['cart']);
}
?>

<!-- Page Banner -->
<section class="page-banner">
    <div class="container">
        <h1>Shopping Cart</h1>
        <p><a href="index.php">Home</a> / Cart</p>
    </div>
</section>

<!-- Cart Section -->
<section class="cart-section section-padding">
    <div class="container">
        <?php
        $cartItems = getCartItems();
        
        if(empty($cartItems)):
        ?>
        <div class="empty-cart">
            <i class="fas fa-shopping-cart"></i>
            <h2>Your cart is empty</h2>
            <p>Looks like you haven't added any items to your cart yet.</p>
            <a href="products.php" class="btn-primary">Continue Shopping</a>
        </div>
        <?php else: ?>
        
        <div class="cart-layout">
            <div class="cart-items">
                <div class="cart-header">
                    <span>Product</span>
                    <span>Price</span>
                    <span>Quantity</span>
                    <span>Total</span>
                    <span>Action</span>
                </div>
                
                <?php foreach($cartItems as $item): ?>
                <div class="cart-item">
                    <div class="item-product">
                        <img src="images/products/<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" onerror="this.src='https://via.placeholder.com/100x100?text=Product'">
                        <div>
                            <h4><a href="product.php?slug=<?php echo $item['slug']; ?>"><?php echo $item['name']; ?></a></h4>
                            <p><?php echo $item['short_description']; ?></p>
                        </div>
                    </div>
                    <div class="item-price">
                        <?php if($item['sale_price']): ?>
                        <?php echo formatPrice($item['sale_price']); ?>
                        <?php else: ?>
                        <?php echo formatPrice($item['price']); ?>
                        <?php endif; ?>
                    </div>
                    <div class="item-quantity">
                        <form method="POST" class="qty-form">
                            <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                            <input type="hidden" name="update_qty" value="1">
                            <div class="quantity-control">
                                <button type="submit" name="quantity" value="<?php echo max(0, $item['quantity'] - 1); ?>">-</button>
                                <input type="number" value="<?php echo $item['quantity']; ?>" min="1" readonly>
                                <button type="submit" name="quantity" value="<?php echo $item['quantity'] + 1; ?>">+</button>
                            </div>
                        </form>
                    </div>
                    <div class="item-total">
                        <?php echo formatPrice($item['item_total']); ?>
                    </div>
                    <div class="item-action">
                        <form method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                            <input type="hidden" name="remove_item" value="1">
                            <button type="submit" class="remove-btn" onclick="return confirm('Remove this item?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <?php endforeach; ?>
                
                <div class="cart-actions">
                    <!-- <form method="POST">
                        <input type="hidden" name="clear_cart" value="1">
                        <button type="submit" class="btn-secondary" onclick="return confirm('Clear all items?')">Clear Cart</button>
                    </form> -->
                    <a href="products.php" class="btn-secondary">Continue Shopping</a>
                </div>
            </div>
            
            <div class="cart-summary">
                <h3>Cart Summary</h3>
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
                <a href="checkout.php" class="btn-primary checkout-btn">Proceed to Checkout</a>
                <p class="secure-text"><i class="fas fa-lock"></i> Secure checkout</p>
            </div>
        </div>
        
        <?php endif; ?>
    </div>
</section>

<style>
.qty-form {
    display: flex;
    align-items: center;
}
.qty-form .quantity-control {
    display: flex;
    align-items: center;
    border: 1px solid #dedede;
    border-radius: 5px;
    overflow: hidden;
}
.qty-form .quantity-control button {
    width: 35px;
    height: 38px;
    border: none;
    background: #f3f3f3;
    cursor: pointer;
    font-size: 16px;
    transition: all 0.3s;
}
.qty-form .quantity-control button:hover {
    background: #fc8934;
    color: white;
}
.qty-form .quantity-control input {
    width: 50px;
    height: 38px;
    border: none;
    text-align: center;
    font-size: 14px;
    background: white;
}
.cart-actions {
    display: flex;
    gap: 15px;
    margin-top: 20px;
    flex-wrap: wrap;
}
.cart-actions .btn-secondary,
.cart-actions .btn-primary {
    padding: 12px 25px;
    text-decoration: none;
    display: inline-block;
}
</style>

<?php require_once 'inc/footer.php'; ?>
