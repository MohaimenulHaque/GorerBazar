<?php
require_once 'inc/functions.php';

$success_msg = isset($_GET['msg']) ? 'Product added to cart!' : '';
$success_msg = isset($_GET['order_success']) ? 'Order placed successfully!' : '';
require_once 'inc/header.php';
?>

<?php if($success_msg): ?>
<div style="background: #d4edda; color: #155724; padding: 15px; text-align: center; position: relative;">
    <?php echo $success_msg; ?>
    <!-- <a href="cart.php" href="#" style="margin-left: 15px; color: #155724; font-weight: bold;">View Cart</a> -->
</div>
<?php endif; ?>

<!-- Hero Slider -->
<section class="hero-slider">
    <div class="slider-container">
        <div class="slider-wrapper">
            <div class="slide active" style="background: linear-gradient(135deg, #fc8934 0%, #ffb366 100%);">
                <div class="container">
                    <div class="slide-content">
                        <h2>Fresh Vegetables & Fruits</h2>
                        <p>Get fresh produce delivered to your doorstep</p>
                        <a href="products.php" class="btn-primary">Shop Now</a>
                    </div>
                </div>
            </div>
            <div class="slide" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
                <div class="container">
                    <div class="slide-content">
                        <h2>Organic & Fresh</h2>
                        <p>100% fresh and organic products</p>
                        <a href="products.php" class="btn-primary">Shop Now</a>
                    </div>
                </div>
            </div>
            <div class="slide" style="background: linear-gradient(135deg, #dc3545 0%, #e4606a 100%);">
                <div class="container">
                    <div class="slide-content">
                        <h2>Best Quality Meat</h2>
                        <p>Fresh meat and fish available</p>
                        <a href="products.php" class="btn-primary">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
        <button class="slider-prev"><i class="fas fa-chevron-left"></i></button>
        <button class="slider-next"><i class="fas fa-chevron-right"></i></button>
    </div>
</section>

<!-- Featured Products -->
<section class="featured-products section-padding">
    <div class="container">
        <div class="section-title">
            <h2>Featured Products</h2>
            <p>Our most popular products</p>
        </div>
        
        <div class="products-grid">
            <?php
            $featured = getFeaturedProducts(8);
            foreach($featured as $product):
            ?>
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
        </div>
    </div>
</section>

<!-- Categories -->
<section class="categories-section section-padding">
    <div class="container">
        <div class="section-title">
            <h2>Shop by Category</h2>
            <p>Browse our categories</p>
        </div>
        
        <div class="categories-grid">
            <?php
            $categories = getAllCategories();
            foreach($categories as $cat):
            ?>
            <div class="category-card">
                <div class="category-icon">
                    <i class="fas fa-apple-alt"></i>
                </div>
                <h3><a href="category.php?slug=<?php echo $cat['slug']; ?>"><?php echo $cat['name']; ?></a></h3>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Promo Banner -->
<section class="promo-banner">
    <div class="container">
        <div class="promo-content">
            <h2>Free Delivery on Orders Over ৳500</h2>
            <p>Shop now and enjoy free home delivery</p>
            <a href="products.php" class="btn-primary">Shop Now</a>
        </div>
    </div>
</section>

<!-- Latest Products -->
<section class="latest-products section-padding">
    <div class="container">
        <div class="section-title">
            <h2>Latest Products</h2>
            <p>New arrivals in our store</p>
        </div>
        
        <div class="products-grid">
            <?php
            $latest = getProducts(8);
            foreach($latest as $product):
            ?>
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
        </div>
    </div>
</section>

<!-- Services -->
<section class="services-section section-padding">
    <div class="container">
        <div class="services-grid">
            <div class="service-box">
                <div class="service-icon">
                    <i class="fas fa-truck"></i>
                </div>
                <h3>Fast Delivery</h3>
                <p>Quick delivery to your doorstep</p>
            </div>
            <div class="service-box">
                <div class="service-icon">
                    <i class="fas fa-leaf"></i>
                </div>
                <h3>Fresh Products</h3>
                <p>100% fresh and organic</p>
            </div>
            <div class="service-box">
                <div class="service-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <h3>24/7 Support</h3>
                <p>Round the clock customer support</p>
            </div>
            <div class="service-box">
                <div class="service-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3>Secure Payment</h3>
                <p>100% secure payment options</p>
            </div>
        </div>
    </div>
</section>

<?php require_once 'inc/footer.php'; ?>
