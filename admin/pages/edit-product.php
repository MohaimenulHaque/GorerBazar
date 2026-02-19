<?php
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$product = null;

if($id > 0) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
}

$categories = getAllCategories();

if(isset($_POST['update_product'])) {
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
    $status = $_POST['status'];
    
    $stmt = $conn->prepare("UPDATE products SET name=?, slug=?, description=?, short_description=?, price=?, sale_price=?, sku=?, image=?, category_id=?, stock=?, featured=?, status=? WHERE id=?");
    $stmt->bind_param("ssssdssssissi", $name, $slug, $description, $short_description, $price, $sale_price, $sku, $image, $category_id, $stock, $featured, $status, $id);
    
    if($stmt->execute()) {
        echo '<div class="alert alert-success">Product updated successfully!</div>';
        $product = array_merge($product, $_POST);
    } else {
        echo '<div class="alert alert-error">Failed to update product!</div>';
    }
}
?>

<div class="form-container">
    <h2 style="margin-bottom: 25px;">Edit Product</h2>
    
    <?php if($product): ?>
    <form method="POST" action="">
        <div class="form-row">
            <div class="form-group">
                <label>Product Name *</label>
                <input type="text" name="name" value="<?php echo $product['name']; ?>" required>
            </div>
            <div class="form-group">
                <label>SKU</label>
                <input type="text" name="sku" value="<?php echo $product['sku']; ?>">
            </div>
        </div>
        
        <div class="form-group">
            <label>Short Description</label>
            <input type="text" name="short_description" value="<?php echo $product['short_description']; ?>">
        </div>
        
        <div class="form-group">
            <label>Description</label>
            <textarea name="description"><?php echo $product['description']; ?></textarea>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label>Price *</label>
                <input type="number" name="price" step="0.01" value="<?php echo $product['price']; ?>" required>
            </div>
            <div class="form-group">
                <label>Sale Price</label>
                <input type="number" name="sale_price" step="0.01" value="<?php echo $product['sale_price']; ?>">
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label>Category</label>
                <select name="category_id">
                    <option value="">Select Category</option>
                    <?php foreach($categories as $cat): ?>
                    <option value="<?php echo $cat['id']; ?>" <?php echo $product['category_id']==$cat['id']?'selected':''; ?>><?php echo $cat['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Stock</label>
                <input type="number" name="stock" value="<?php echo $product['stock']; ?>">
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label>Image Filename</label>
                <input type="text" name="image" value="<?php echo $product['image']; ?>">
            </div>
            <div class="form-group">
                <label>Featured</label>
                <select name="featured">
                    <option value="no" <?php echo $product['featured']=='no'?'selected':''; ?>>No</option>
                    <option value="yes" <?php echo $product['featured']=='yes'?'selected':''; ?>>Yes</option>
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <label>Status</label>
            <select name="status">
                <option value="active" <?php echo $product['status']=='active'?'selected':''; ?>>Active</option>
                <option value="inactive" <?php echo $product['status']=='inactive'?'selected':''; ?>>Inactive</option>
            </select>
        </div>
        
        <button type="submit" name="update_product" class="btn-submit">Update Product</button>
    </form>
    <?php else: ?>
    <p>Product not found!</p>
    <?php endif; ?>
</div>
