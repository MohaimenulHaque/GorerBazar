<?php
if(isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];
    updateOrderStatus($order_id, $status);
    echo '<div class="alert alert-success">Order status updated successfully!</div>';
}

$orders = getAllOrders();
?>

<div class="data-table">
    <div class="table-header">
        <h2>All Orders</h2>
    </div>
    <table>
        <thead>
            <tr>
                <th>Order #</th>
                <th>Customer</th>
                <th>Phone</th>
                <th>Total</th>
                <th>Payment</th>
                <th>Status</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($orders as $order): ?>
            <tr>
                <td><?php echo $order['order_number']; ?></td>
                <td><?php echo $order['customer_name'] ?: 'Guest'; ?></td>
                <td><?php echo $order['shipping_phone']; ?></td>
                <td>৳<?php echo number_format($order['total'], 0); ?></td>
                <td><?php echo ucfirst($order['payment_method']); ?></td>
                <td><span class="status-badge status-<?php echo $order['order_status']; ?>"><?php echo ucfirst($order['order_status']); ?></span></td>
                <td><?php echo date('d M Y', strtotime($order['created_at'])); ?></td>
                <td>
                    <form method="POST" style="display:flex; gap:5px;">
                        <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
                        <select name="status" style="padding:5px; font-size:12px;">
                            <option value="pending" <?php echo $order['order_status']=='pending'?'selected':''; ?>>Pending</option>
                            <option value="processing" <?php echo $order['order_status']=='processing'?'selected':''; ?>>Processing</option>
                            <option value="shipped" <?php echo $order['order_status']=='shipped'?'selected':''; ?>>Shipped</option>
                            <option value="delivered" <?php echo $order['order_status']=='delivered'?'selected':''; ?>>Delivered</option>
                            <option value="cancelled" <?php echo $order['order_status']=='cancelled'?'selected':''; ?>>Cancelled</option>
                        </select>
                        <button type="submit" name="update_status" class="btn-edit">Update</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
