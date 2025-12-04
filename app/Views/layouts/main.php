<?php
// $viewFile is defined in Controller::view()
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= isset($title) ? htmlspecialchars($title) : 'MyShop' ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- You can add Bootstrap / Tailwind CSS here later -->
</head>
<body>
<header>
    <?php
$config = require dirname(__DIR__, 3) . '/config/config.php';
$baseUrl = rtrim($config['app']['base_url'], '/');
?>

<nav>
    <a href="<?= $baseUrl ?>/home/index">Home</a> |

    <?php if (!empty($_SESSION['user'])): ?>
        <span>Hi, <?= htmlspecialchars($_SESSION['user']['name']) ?></span> |
        <a href="<?= $baseUrl ?>/auth/logout">Logout</a>
    <?php else: ?>
        <a href="<?= $baseUrl ?>/auth/login">Login</a> |
        <a href="<?= $baseUrl ?>/auth/register">Register</a>
    <?php endif; ?>
</nav>
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
</body>
</html>
