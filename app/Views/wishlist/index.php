<h1>My Wishlist</h1>

<?php if (empty($wishlist)): ?>
    <p>No items in wishlist</p>
    <a href="/ecommerce-mvc/public/home/index" class="btn btn-secondary">Continue Shopping</a>
<?php else: ?>

<table class="table">
    <tr>
        <th>Image</th>
        <th>Name</th>
        <th>Price</th>
        <th></th>
    </tr>

<?php foreach ($wishlist as $item): ?>
    <tr>
        <td>
            <?php if (!empty($item['image'])): ?>
                <img src="/ecommerce-mvc/public<?= $item['image'] ?>" width="80">
            <?php endif; ?>
        </td>
        <td><?= $item['name'] ?></td>
        <td>₹<?= $item['price'] ?></td>
        <td>
            <a href="/ecommerce-mvc/public/wishlist/remove/<?= $item['id'] ?>" class="btn btn-danger">Remove</a>
        </td>
    </tr>
<?php endforeach; ?>
</table>

<a href="/ecommerce-mvc/public/cart/index" class="btn btn-success">Go to Cart</a>
<?php endif; ?>
