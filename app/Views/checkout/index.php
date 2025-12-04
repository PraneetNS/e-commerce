<h1>Checkout</h1>

<?php if (!empty($_SESSION['error'])): ?>
    <p style="color:red"><?= $_SESSION['error']; unset($_SESSION['error']); ?></p>
<?php endif; ?>

<table border="1" cellpadding="5">
    <tr>
        <th>Name</th>
        <th>Qty</th>
        <th>Price</th>
        <th>Total</th>
    </tr>

<?php $grand = 0; foreach ($cart as $item): 
    $total = $item['qty'] * $item['price'];
    $grand += $total;
?>
    <tr>
        <td><?= $item['name'] ?></td>
        <td><?= $item['qty'] ?></td>
        <td>₹<?= $item['price'] ?></td>
        <td>₹<?= $total ?></td>
    </tr>
<?php endforeach; ?>
</table>

<h3>Grand Total: ₹<?= $grand ?></h3>

<form action="/ecommerce-mvc/public/checkout/placeOrder" method="post">
    <label>Shipping Address:</label><br>
    <textarea name="address" required></textarea><br><br>
    <button type="submit">Place Order</button>
</form>
