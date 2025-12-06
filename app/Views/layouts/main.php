<?php
// $viewFile is defined in Controller::view()
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= isset($title) ? htmlspecialchars($title) : 'MyShop' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
<header>
    <?php
$config = require dirname(__DIR__, 3) . '/config/config.php';
$baseUrl = rtrim($config['app']['base_url'], '/');
?>

<nav>
    <a href="<?= $baseUrl ?>/cart/index">Cart (<?= isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0 ?>)</a> |
    | <a href="<?= $baseUrl ?>/wishlist/index">Wishlist (<?= isset($_SESSION['wishlist']) ? count($_SESSION['wishlist']) : 0 ?>)</a>

| <a href="<?= $baseUrl ?>/orders/index">My Orders</a>
| <a href="<?= $baseUrl ?>/adminOrder/index">Orders</a>

    <a href="<?= $baseUrl ?>/home/index">Home</a> |
    <?php if (!empty($_SESSION['user'])): ?>
        <span>Hi, <?= htmlspecialchars($_SESSION['user']['name']) ?></span> |
        <?php if ($_SESSION['user']['role'] === 'admin'): ?>
            <a href="<?= $baseUrl ?>/admin/index">Admin Panel</a> |
            | <a href="<?= $baseUrl ?>/adminDashboard/index">Dashboard</a>

        <?php endif; ?>
        <a href="<?= $baseUrl ?>/auth/logout">Logout</a>
    <?php else: ?>
        <a href="<?= $baseUrl ?>/auth/login">Login</a> |
        <a href="<?= $baseUrl ?>/auth/register">Register</a>
    <?php endif; ?>
</nav>
<hr>

<hr>


    <hr>
</header>

<main>
    <?php require $viewFile; ?>
</main>

<footer>
    <hr>
    <p>&copy; <?= date('Y') ?> MyShop</p>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<body class="container mt-4">

</body>
</html>
