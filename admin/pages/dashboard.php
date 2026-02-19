<?php
$recentOrders = getAllOrders();
$recentOrders = array_slice($recentOrders, 0, 10);
?>

<div class="stats-grid">
    <div class="stat-card">
        <h3>Total Orders</h3>
        <div class="value"><?php echo $totalOrders; ?></div>
        <div class="icon"><i class="fas fa-shopping-cart"></i></div>
    </div>
    <div class="stat-card">
        <h3>Pending Orders</h3>
        <div class="value"><?php echo $pendingOrders; ?></div>
        <div class="icon"><i class="fas fa-clock"></i></div>
    </div>
    <div class="stat-card">
        <h3>Total Sales</h3>
        <div class="value">৳<?php echo number_format($totalSales, 0); ?></div>
        <div class="icon"><i class="fas fa-taka"></i></div>
    </div>
    <div class="stat-card">
        <h3>Total Products</h3>
        <div class="value"><?php echo $totalProducts; ?></div>
        <div class="icon"><i class="fas fa-box"></i></div>
    </div>
</div>

<div class="data-table">
    <div class="table-header">
        <h2>Recent Orders</h2>
        <a href="?page=orders" class="btn-add">View All</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>Order #</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Status</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($recentOrders as $order): ?>
            <tr>
                <td><?php echo $order['order_number']; ?></td>
                <td><?php echo $order['customer_name'] ?: 'Guest'; ?></td>
                <td>৳<?php echo number_format($order['total'], 0); ?></td>
                <td><span class="status-badge status-<?php echo $order['order_status']; ?>"><?php echo ucfirst($order['order_status']); ?></span></td>
                <td><?php echo date('d M Y', strtotime($order['created_at'])); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
