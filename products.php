<?php
require_once 'inc/functions.php';
$pageTitle = 'All Products';
$success_msg = isset($_GET['msg']) ? 'Product added to cart!' : '';
require_once 'inc/header.php';
?>

<?php if($success_msg): ?>
<div style="background: #d4edda; color: #155724; padding: 15px; text-align: center; position: relative;">
    <?php echo $success_msg; ?>
    <a href="cart.php" style="margin-left: 15px; color: #155724; font-weight: bold;">View Cart</a>
</div>
<?php endif; ?>

<!-- Page Banner -->
<section class="page-banner">
    <div class="container">
        <h1>All Products</h1>
        <p><a href="index.php">Home</a> / Products</p>
    </div>
</section>

<!-- Products Section -->
<section class="products-section section-padding">
    <div class="container">
        <div class="products-layout">
            <!-- Sidebar -->
            <aside class="products-sidebar">
                <div class="sidebar-widget">
                    <h3>Categories</h3>
                    <ul class="category-list">
                        <li><a href="products.php" class="<?php echo !isset($_GET['category']) ? 'active' : ''; ?>">All Products</a></li>
                        <?php
                        $categories = getAllCategories();
                        foreach($categories as $cat):
                        ?>
                        <li><a href="products.php?category=<?php echo $cat['id']; ?>" <?php echo (isset($_GET['category']) && $_GET['category'] == $cat['id']) ? 'class="active"' : ''; ?>><?php echo $cat['name']; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <div class="sidebar-widget">
                    <h3>Price Range</h3>
                    <div class="price-filter">
                        <input type="range" min="0" max="1000" value="500" id="priceRange">
                        <div class="price-values">
                            <span>৳0</span>
                            <span>৳<span id="priceValue">500</span></span>
                        </div>
                    </div>
                </div>
            </aside>
            
            <!-- Products Grid -->
             <?php 
             $category_id = isset($_GET['category']) ? $_GET['category'] : null;
             $products = getProducts(0, $category_id);
             ?>
            <div class="products-main">
                <div class="products-header">
                    <div class="results-count">Showing <?php echo count($products); ?> products</div>
                    <div class="sort-options">
                        <select id="sortBy">
                            <option value="newest">Newest First</option>
                            <option value="price-low">Price: Low to High</option>
                            <option value="price-high">Price: High to Low</option>
                        </select>
                    </div>
                </div>
                
                <div class="products-grid">
                    <?php
                    // $category_id = isset($_GET['category']) ? $_GET['category'] : null;
                    // $products = getProducts(0, $category_id);
                    
                    if(empty($products)):
                    ?>
                    <div class="no-products">
                        <i class="fas fa-shopping-bag"></i>
                        <h3>No products found</h3>
                        <p>Try adjusting your search or filter</p>
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
        </div>
    </div>
</section>

<?php require_once 'inc/footer.php'; ?>
