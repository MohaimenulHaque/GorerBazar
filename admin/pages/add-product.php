<?php
$categories = getAllCategories();

if(isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $slug = strtolower(str_replace(' ', '-', $name));
    $description = $_POST['description'];
    $short_description = $_POST['short_description'];
    $price = $_POST['price'];
    $sale_price = $_POST['sale_price'] ?: null;
    $sku = $_POST['sku'];
    $image = $_POST['image'] ?: 'default.jpg';
    $category_id = $_POST['category_id'];
    $stock = $_POST['stock'];
    $featured = $_POST['featured'];
    
    $stmt = $conn->prepare("INSERT INTO products (name, slug, description, short_description, price, sale_price, sku, image, category_id, stock, featured, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'active')");
    $stmt->bind_param("ssssdssssiss", $name, $slug, $description, $short_description, $price, $sale_price, $sku, $image, $category_id, $stock, $featured);
    
    if($stmt->execute()) {
        echo '<div class="alert alert-success">Product added successfully!</div>';
    } else {
        echo '<div class="alert alert-error">Failed to add product!</div>';
    }
}
?>

<div class="form-container">
    <h2 style="margin-bottom: 25px;">Add New Product</h2>
    
    <form method="POST" action="">
        <div class="form-row">
            <div class="form-group">
                <label>Product Name *</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label>SKU</label>
                <input type="text" name="sku" placeholder="e.g., PROD-001">
            </div>
        </div>
        
        <div class="form-group">
            <label>Short Description</label>
            <input type="text" name="short_description">
        </div>
        
        <div class="form-group">
            <label>Description</label>
            <textarea name="description"></textarea>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label>Price *</label>
                <input type="number" name="price" step="0.01" required>
            </div>
            <div class="form-group">
                <label>Sale Price</label>
                <input type="number" name="sale_price" step="0.01">
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label>Category</label>
                <select name="category_id">
                    <option value="">Select Category</option>
                    <?php foreach($categories as $cat): ?>
                    <option value="<?php echo $cat['id']; ?>"><?php echo $cat['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Stock</label>
                <input type="number" name="stock" value="0">
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label>Image Filename</label>
                <input type="text" name="image" placeholder="e.g., product.jpg">
            </div>
            <div class="form-group">
                <label>Featured</label>
                <select name="featured">
                    <option value="no">No</option>
                    <option value="yes">Yes</option>
                </select>
            </div>
        </div>
        
        <button type="submit" name="add_product" class="btn-submit">Add Product</button>
    </form>
</div>
