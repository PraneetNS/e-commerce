<h1><?= htmlspecialchars($title) ?></h1>
<p><?= htmlspecialchars($message) ?></p>

<?php if (!empty($products)): ?>
    <h2>Featured Products</h2>
    <ul>
<?php foreach ($products as $product): ?>
    <li>
        <strong><?= htmlspecialchars($product['name']) ?></strong>
        – ₹<?= htmlspecialchars($product['price']) ?>
        <a href="/ecommerce-mvc/public/cart/add/<?= $product['id'] ?>">Add to Cart</a>
    </li>
<?php endforeach; ?>
</ul>

<?php else: ?>
    <p>No featured products yet.</p>
<?php endif; ?>

<p>Next: we’ll build authentication (register/login) and admin product management.</p>
