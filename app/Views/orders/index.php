<h1>My Orders</h1>

<?php if (!empty($_SESSION['error'])): ?>
    <p style="color:red"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
<?php endif; ?>

<?php if (empty($orders)): ?>
    <p>No orders found.</p>
<?php else: ?>

<table border="1" cellpadding="5">
    <tr>
        <th>Order ID</th>
        <th>Total</th>
        <th>Status</th>
        <th>Date</th>
        <th>Action</th>
    </tr>

<?php foreach ($orders as $o): ?>
    <tr>
        <td><?= $o['id'] ?></td>
        <td>₹<?= $o['total'] ?></td>
        <td><?= $o['status'] ?></td>
        <td><?= $o['created_at'] ?></td>
        <td><a href="/ecommerce-mvc/public/orders/details/<?= $o['id'] ?>">View</a></td>

    </tr>
<?php endforeach; ?>

</table>

<?php endif; ?>

<a href="/ecommerce-mvc/public/home/index">Back to Home</a>
