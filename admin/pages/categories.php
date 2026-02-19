<?php
if(isset($_POST['add_category'])) {
    $name = $_POST['name'];
    $slug = strtolower(str_replace(' ', '-', $name));
    $description = $_POST['description'];
    
    $stmt = $conn->prepare("INSERT INTO categories (name, slug, description, status) VALUES (?, ?, ?, 'active')");
    $stmt->bind_param("sss", $name, $slug, $description);
    
    if($stmt->execute()) {
        echo '<div class="alert alert-success">Category added successfully!</div>';
    }
}

$categories = getAllCategories();
?>

<div class="form-container" style="max-width: 600px; margin-bottom: 30px;">
    <h2 style="margin-bottom: 25px;">Add New Category</h2>
    
    <form method="POST" action="">
        <div class="form-group">
            <label>Category Name *</label>
            <input type="text" name="name" required>
        </div>
        
        <div class="form-group">
            <label>Description</label>
            <textarea name="description"></textarea>
        </div>
        
        <button type="submit" name="add_category" class="btn-submit">Add Category</button>
    </form>
</div>

<div class="data-table">
    <div class="table-header">
        <h2>All Categories</h2>
    </div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Products</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($categories as $cat): ?>
            <?php $count = $conn->query("SELECT COUNT(*) as c FROM products WHERE category_id = {$cat['id']}")->fetch_assoc()['c']; ?>
            <tr>
                <td><?php echo $cat['id']; ?></td>
                <td><?php echo $cat['name']; ?></td>
                <td><?php echo $cat['slug']; ?></td>
                <td><?php echo $count; ?></td>
                <td><span class="status-badge status-<?php echo $cat['status']; ?>"><?php echo ucfirst($cat['status']); ?></span></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
