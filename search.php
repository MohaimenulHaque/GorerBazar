<?php
require_once 'inc/functions.php';
$pageTitle = 'Search';
$success_msg = isset($_GET['msg']) ? 'Product added to cart!' : '';
require_once 'inc/header.php';

$query = isset($_GET['q']) ? $_GET['q'] : '';
$results = $query ? searchProducts($query) : [];
?>

<?php if($success_msg): ?>
<div style="background: #d4edda; color: #155724; padding: 15px; text-align: center;">
    <?php echo $success_msg; ?>
    <a href="cart.php" style="margin-left: 15px; color: #155724; font-weight: bold;">View Cart</a>
</div>
<?php endif; ?>

<!-- Page Banner -->
<section class="page-banner">
    <div class="container">
        <h1>Search Results</h1>
        <p><a href="index.php">Home</a> / Search: "<?php echo htmlspecialchars($query); ?>"</p>
    </div>
</section>

<!-- Search Results -->
<section class="products-section section-padding">
    <div class="container">
        <p class="results-count">Found <?php echo count($results); ?> products for "<?php echo htmlspecialchars($query); ?>"</p>
        
        <div class="products-grid">
            <?php if(empty($results)): ?>
            <div class="no-products">
                <i class="fas fa-search"></i>
                <h3>No products found</h3>
                <p>Try different keywords</p>
                <a href="products.php" class="btn-primary">Browse All Products</a>
            </div>
            <?php else: ?>
            
            <?php foreach($results as $product): ?>
            <div class="product-card">
                <?php if($product['sale_price']): ?>
                <span class="sale-badge">Sale</span>
                <?php endif; ?>
                <div class="product-image">
                    <img src="images/products/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" onerror="this.src='https://via.placeholder.com/300x300?text=Product'">
                </div>
                    <div class="product-info">
                    <h3><a href="product.php?slug=<?php echo $product['slug']; ?>"><?php echo $product['name']; ?></a></h3>
                    <div class="price">
                        <?php if($product['sale_price']): ?>
                        <span class="new-price"><?php echo formatPrice($product['sale_price']); ?></span>
                        <span class="old-price"><?php echo formatPrice($product['price']); ?></span>
                        <?php else: ?>
                        <span class="new-price"><?php echo formatPrice($product['price']); ?></span>
                        <?php endif; ?>
                    </div>
                    <form method="POST" action="add-to-cart.php">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" name="add_to_cart" class="add-to-cart-btn">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </button>
                    </form>
                </div>
            </div>
            <?php endforeach; ?>
            
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once 'inc/footer.php'; ?>
