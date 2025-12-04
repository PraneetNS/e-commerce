<h1>Manage Orders</h1>

<?php if (!empty($_SESSION['success'])): ?>
    <p style="color:green"><?= $_SESSION['success']; unset($_SESSION['success']); ?></p>
<?php endif; ?>

<table border="1" cellpadding="5">
    <tr>
        <th>Order ID</th>
        <th>Customer</th>
        <th>Email</th>
        <th>Status</th>
        <th>Total</th>
        <th>Date</th>
        <th>Action</th>
    </tr>

<?php foreach ($orders as $order): ?>
    <tr>
        <td><?= $order['id'] ?></td>
        <td><?= $order['name'] ?></td>
        <td><?= $order['email'] ?></td>
        <td><?= $order['status'] ?></td>
        <td>₹<?= $order['total'] ?></td>
        <td><?= $order['created_at'] ?></td>
        <td>
            <form action="/ecommerce-mvc/public/adminOrder/updateStatus" method="post">
                <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                <select name="status">
                    <option <?= $order['status'] === 'pending' ? 'selected' : '' ?>>pending</option>
                    <option <?= $order['status'] === 'paid' ? 'selected' : '' ?>>paid</option>
                    <option <?= $order['status'] === 'shipped' ? 'selected' : '' ?>>shipped</option>
                    <option <?= $order['status'] === 'completed' ? 'selected' : '' ?>>completed</option>
                    <option <?= $order['status'] === 'cancelled' ? 'selected' : '' ?>>cancelled</option>
                </select>
                <button type="submit">Update</button>
            </form>
        </td>
    </tr>
<?php endforeach; ?>

</table>
