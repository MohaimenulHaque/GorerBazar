<?php
require_once 'inc/functions.php';

$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
$category = getCategoryBySlug($slug);
$success_msg = isset($_GET['msg']) ? 'Product added to cart!' : '';

if(!$category) {
    header('Location: products.php');
    exit;
}

$pageTitle = $category['name'];
require_once 'inc/header.php';
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
        <h1><?php echo $category['name']; ?></h1>
        <p><a href="index.php">Home</a> / <?php echo $category['name']; ?></p>
    </div>
</section>

<!-- Category Products -->
<section class="products-section section-padding">
    <div class="container">
        <div class="category-description">
            <p><?php echo $category['description']; ?></p>
        </div>
        
        <div class="products-grid">
            <?php
            $products = getProducts(0, $category['id']);
            
            if(empty($products)):
            ?>
            <div class="no-products">
                <i class="fas fa-shopping-bag"></i>
                <h3>No products found in this category</h3>
                <p>Check back later for new products</p>
            </div>
            <?php else: ?>
            
            <?php foreach($products as $product): ?>
            <div class="product-card">
                <?php if($product['sale_price']): ?>
                <span class="sale-badge">Sale</span>
                <?php endif; ?>
                <div class="product-image">
                    <img src="images/products/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" onerror="this.src='https://via.placeholder.com/300x300?text=Product'">
                    <div class="product-actions">
                        <button class="quick-view" onclick="quickView(<?php echo $product['id']; ?>)"><i class="fas fa-eye"></i></button>
                        <button class="add-to-wishlist"><i class="fas fa-heart"></i></button>
                    </div>
                </div>
                <div class="product-info">
                    <h3><a href="product.php?slug=<?php echo $product['slug']; ?>"><?php echo $product['name']; ?></a></h3>
                    <p class="short-desc"><?php echo $product['short_description']; ?></p>
                    <div class="price">
                        <?php if($product['sale_price']): ?>
                        <span class="new-price"><?php echo formatPrice($product['sale_price']); ?></span>
                        <span class="old-price"><?php echo formatPrice($product['price']); ?></span>
                        <?php else: ?>
                        <span class="new-price"><?php echo formatPrice($product['price']); ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="product-footer">
                        <form method="POST" action="add-to-cart.php" style="display:flex; gap:10px; width:100%;">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" name="add_to_cart" class="add-to-cart-btn" style="flex:1;">
                                <i class="fas fa-shopping-cart"></i> Add to Cart
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once 'inc/footer.php'; ?>
