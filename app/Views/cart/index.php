<h1>Your Cart</h1>

<?php if (!empty($_SESSION['success'])): ?>
    <p style="color:green"><?= $_SESSION['success']; unset($_SESSION['success']); ?></p>
<?php endif; ?>

<?php if (empty($cart)): ?>
    <p>Your cart is empty.</p>
    <a href="/ecommerce-mvc/public/home/index">Continue Shopping</a>

<?php else: ?>

<table border="1" cellpadding="5">
    <tr>
        <th>Name</th>
        <th>Price</th>
        <th>Qty</th>
        <th>Total</th>
        <th>Action</th>
    </tr>

    <?php
    $grandTotal = 0;
    foreach ($cart as $item):
        $total = $item['price'] * $item['qty'];
        $grandTotal += $total;
    ?>
    <tr>
        <td><?= $item['name'] ?></td>
        <td>₹<?= $item['price'] ?></td>
        <td>
            <form action="/ecommerce-mvc/public/cart/update/<?= $item['id'] ?>" method="post">
                <input type="number" name="qty" value="<?= $item['qty'] ?>" min="1">
                <button>Update</button>
            </form>
        </td>
        <td>₹<?= $total ?></td>
        <td><a href="/ecommerce-mvc/public/cart/remove/<?= $item['id'] ?>">Remove</a></td>
    </tr>
    <?php endforeach; ?>
</table>

<h3>Grand Total: ₹<?= $grandTotal ?></h3>

<a href="/ecommerce-mvc/public/home/index">Continue Shopping</a> | 
<a href="/ecommerce-mvc/public/checkout/index">Checkout</a>


<?php endif; ?>
