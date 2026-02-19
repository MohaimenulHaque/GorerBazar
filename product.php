<?php
require_once 'inc/functions.php';
$pageTitle = 'Product Details';
$success_msg = isset($_GET['msg']) ? 'Product added to cart!' : '';
require_once 'inc/header.php';

if(!isset($_GET['slug'])) {
    header('Location: products.php');
    exit;
}

$product = getProductBySlug($_GET['slug']);

if(!$product) {
    header('Location: products.php');
    exit;
}

$pageTitle = $product['name'];
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
        <h1><?php echo $product['name']; ?></h1>
        <p><a href="index.php">Home</a> / <a href="products.php">Products</a> / <?php echo $product['name']; ?></p>
    </div>
</section>

<!-- Product Details -->
<section class="product-details-section section-padding">
    <div class="container">
        <div class="product-details-layout">
            <div class="product-gallery">
                <div class="main-image">
                    <img src="images/products/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" id="mainProductImage" onerror="this.src='https://via.placeholder.com/500x500?text=Product'">
                </div>
            </div>
            
            <div class="product-info-details">
                <h1><?php echo $product['name']; ?></h1>
                
                <div class="product-price">
                    <?php if($product['sale_price']): ?>
                    <span class="sale-price"><?php echo formatPrice($product['sale_price']); ?></span>
                    <span class="regular-price"><?php echo formatPrice($product['price']); ?></span>
                    <span class="discount-badge"><?php echo round(($product['price'] - $product['sale_price']) / $product['price'] * 100); ?>% OFF</span>
                    <?php else: ?>
                    <span class="sale-price"><?php echo formatPrice($product['price']); ?></span>
                    <?php endif; ?>
                </div>
                
                <p class="short-description"><?php echo $product['short_description']; ?></p>
                
                <div class="stock-status">
                    <?php if($product['stock'] > 0): ?>
                    <span class="in-stock"><i class="fas fa-check-circle"></i> In Stock (<?php echo $product['stock']; ?> available)</span>
                    <?php else: ?>
                    <span class="out-of-stock"><i class="fas fa-times-circle"></i> Out of Stock</span>
                    <?php endif; ?>
                </div>
                
                <?php if($product['stock'] > 0): ?>
                <div class="add-to-cart-section">
                    <form method="POST" action="add-to-cart.php" style="display:flex; gap:15px; flex:1;">
                        <input type="number" name="quantity" value="1" min="1" max="<?php echo $product['stock']; ?>" style="width:80px; padding:12px; border:2px solid #dedede; border-radius:5px;">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <button type="submit" name="add_to_cart" class="btn-add-to-cart" style="flex:1;">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </button>
                    </form>
                </div>
                <?php endif; ?>
                
                <div class="product-meta">
                    <p><strong>SKU:</strong> <?php echo $product['sku']; ?></p>
                    <p><strong>Category:</strong> 
                        <?php 
                        $cat = getCategoryById($product['category_id']);
                        echo $cat ? $cat['name'] : 'Uncategorized';
                        ?>
                    </p>
                </div>
                
                <div class="product-actions-detail">
                    <button class="action-btn"><i class="fas fa-heart"></i> Add to Wishlist</button>
                    <button class="action-btn"><i class="fas fa-share-alt"></i> Share</button>
                </div>
            </div>
        </div>
        
        <div class="product-description">
            <div class="description-tabs">
                <button class="tab-btn active" data-tab="description">Description</button>
                <button class="tab-btn" data-tab="reviews">Reviews</button>
            </div>
            
            <div class="tab-content active" id="description">
                <h3>Product Description</h3>
                <p><?php echo $product['description']; ?></p>
            </div>
            
            <div class="tab-content" id="reviews">
                <h3>Customer Reviews</h3>
                <p>No reviews yet. Be the first to review this product.</p>
            </div>
        </div>
    </div>
</section>

<!-- Related Products -->
<section class="related-products section-padding">
    <div class="container">
        <div class="section-title">
            <h2>Related Products</h2>
        </div>
        
        <div class="products-grid">
            <?php
            $related = getProducts(4, $product['category_id']);
            foreach($related as $rel):
                if($rel['id'] != $product['id']):
            ?>
            <div class="product-card">
                <?php if($rel['sale_price']): ?>
                <span class="sale-badge">Sale</span>
                <?php endif; ?>
                <div class="product-image">
                    <img src="images/products/<?php echo $rel['image']; ?>" alt="<?php echo $rel['name']; ?>" onerror="this.src='https://via.placeholder.com/300x300?text=Product'">
                    <div class="product-actions">
                        <button class="quick-view" onclick="quickView(<?php echo $rel['id']; ?>)"><i class="fas fa-eye"></i></button>
                    </div>
                </div>
                <div class="product-info">
                    <h3><a href="product.php?slug=<?php echo $rel['slug']; ?>"><?php echo $rel['name']; ?></a></h3>
                    <div class="price">
                        <?php if($rel['sale_price']): ?>
                        <span class="new-price"><?php echo formatPrice($rel['sale_price']); ?></span>
                        <span class="old-price"><?php echo formatPrice($rel['price']); ?></span>
                        <?php else: ?>
                        <span class="new-price"><?php echo formatPrice($rel['price']); ?></span>
                        <?php endif; ?>
                    </div>
                    <form method="POST" action="../add-to-cart.php">
                        <input type="hidden" name="product_id" value="<?php echo $rel['id']; ?>">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" name="add_to_cart" class="add-to-cart-btn">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </button>
                    </form>
                </div>
            </div>
            <?php 
                endif;
            endforeach; 
            ?>
        </div>
    </div>
</section>

<?php require_once 'inc/footer.php'; ?>
