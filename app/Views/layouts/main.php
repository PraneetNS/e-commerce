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
    <nav>
        <a href="/home/index">Home</a> |
        <a href="/home/about">About</a>
        <!-- Later: Products, Cart, Login, Admin, etc. -->
    </nav>
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
