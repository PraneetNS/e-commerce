<h1>Admin Dashboard</h1>

<?php if (!empty($_SESSION['success'])): ?>
    <p style="color:green"><?= $_SESSION['success'] ?></p>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<ul>
    <li><a href="/ecommerce-mvc/public/admin/products">Manage Products</a></li>
</ul>
