<h1>Order Details (ID: <?= $order['id'] ?>)</h1>

<p><strong>User:</strong> <?= $order['name'] ?> (<?= $order['email'] ?>)</p>
<p><strong>Total:</strong> ₹<?= $order['total'] ?></p>
<p><strong>Status:</strong> <?= $order['status'] ?></p>
<p><strong>Date:</strong> <?= $order['created_at'] ?></p>

<h3>Items</h3>

<table border="1" cellpadding="5">
    <tr>
        <th>Product</th>
        <th>Qty</th>
        <th>Price</th>
        <th>Total</th>
    </tr>

<?php foreach ($order['items'] as $item): ?>
    <tr>
        <td><?= $item['product_name'] ?></td>
        <td><?= $item['qty'] ?></td>
        <td>₹<?= $item['price'] ?></td>
        <td>₹<?= $item['qty'] * $item['price'] ?></td>
    </tr>
<?php endforeach; ?>
</table>

<br>
<a href="/ecommerce-mvc/public/orders/index">Back to Orders</a>
