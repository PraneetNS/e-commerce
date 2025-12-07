<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'MyShop' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php
$config = require dirname(__DIR__, 3) . '/config/config.php';
$baseUrl = rtrim($config['app']['base_url'], '/');
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?= $baseUrl ?>/home/index">MyShop</a>

    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navMain">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navMain">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="<?= $baseUrl ?>/home/index">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= $baseUrl ?>/cart/index">Cart (<?= isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0 ?>)</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= $baseUrl ?>/wishlist/index">Wishlist (<?= isset($_SESSION['wishlist']) ? count($_SESSION['wishlist']) : 0 ?>)</a></li>
        <?php if (!empty($_SESSION['user'])): ?>
          <li class="nav-item"><a class="nav-link" href="<?= $baseUrl ?>/orders/index">My Orders</a></li>
        <?php endif; ?>
        <?php if (!empty($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
          <li class="nav-item"><a class="nav-link" href="<?= $baseUrl ?>/adminDashboard/index">Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= $baseUrl ?>/product/index">Products</a></li>
          <li class="nav-item"><a class="nav-link" href="<?= $baseUrl ?>/adminOrder/index">Orders</a></li>
        <?php endif; ?>
      </ul>

      <ul class="navbar-nav ms-auto">
        <?php if (!empty($_SESSION['user'])): ?>
          <li class="nav-item">
            <span class="navbar-text me-3">Hi, <?= htmlspecialchars($_SESSION['user']['name']) ?></span>
          </li>
          <li class="nav-item">
            <a class="btn btn-outline-light btn-sm" href="<?= $baseUrl ?>/auth/logout">Logout</a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="btn btn-outline-light btn-sm me-2" href="<?= $baseUrl ?>/auth/login">Login</a>
          </li>
          <li class="nav-item">
            <a class="btn btn-primary btn-sm" href="<?= $baseUrl ?>/auth/register">Register</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<main class="container py-4">

  <?php if (!empty($_SESSION['error'])): ?>
      <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
  <?php endif; ?>

  <?php if (!empty($_SESSION['success'])): ?>
      <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
  <?php endif; ?>

  <?= $content ?? '' ?>

</main>

<footer class="text-center py-3 text-muted">
  &copy; <?= date('Y') ?> MyShop
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
