<?php
$customers = getAllCustomers();
?>

<div class="data-table">
    <div class="table-header">
        <h2>All Customers</h2>
    </div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Orders</th>
                <th>Joined</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($customers as $customer): ?>
            <?php $orderCount = $conn->query("SELECT COUNT(*) as c FROM orders WHERE customer_id = {$customer['id']}")->fetch_assoc()['c']; ?>
            <tr>
                <td><?php echo $customer['id']; ?></td>
                <td><?php echo $customer['name']; ?></td>
                <td><?php echo $customer['email'] ?: '-'; ?></td>
                <td><?php echo $customer['phone']; ?></td>
                <td><?php echo $orderCount; ?></td>
                <td><?php echo date('d M Y', strtotime($customer['created_at'])); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
