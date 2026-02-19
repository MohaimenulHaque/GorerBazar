<?php
$products = getProducts();
?>

<div class="data-table">
    <div class="table-header">
        <h2>All Products</h2>
        <a href="?page=add-product" class="btn-add"><i class="fas fa-plus"></i> Add Product</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($products as $product): ?>
            <?php $cat = getCategoryById($product['category_id']); ?>
            <tr>
                <td><?php echo $product['id']; ?></td>
                <td><img src="../images/products/<?php echo $product['image']; ?>" width="50" onerror="this.src='https://via.placeholder.com/50?text=N/A'"></td>
                <td><?php echo $product['name']; ?></td>
                <td><?php echo $cat ? $cat['name'] : '-'; ?></td>
                <td>৳<?php echo number_format($product['sale_price'] ?: $product['price'], 0); ?></td>
                <td><?php echo $product['stock']; ?></td>
                <td><span class="status-badge status-<?php echo $product['status']; ?>"><?php echo ucfirst($product['status']); ?></span></td>
                <td>
                    <div class="action-btns">
                        <a href="?page=edit-product&id=<?php echo $product['id']; ?>" class="btn-edit">Edit</a>
                        <a href="?page=products&delete=<?php echo $product['id']; ?>" class="btn-delete" onclick="return confirm('Are you sure?')">Delete</a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
if(isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM products WHERE id = $id");
    echo '<div class="alert alert-success">Product deleted!</div>';
    echo '<meta http-equiv="refresh" content="1">';
}
?>
