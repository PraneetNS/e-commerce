<h2>Order Successful!</h2>

<?php if (!empty($_SESSION['success'])): ?>
    <p style="color:green"><?= $_SESSION['success']; unset($_SESSION['success']); ?></p>
<?php endif; ?>

<a href="/ecommerce-mvc/public/home/index">Continue Shopping</a>
