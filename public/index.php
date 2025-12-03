<?php
declare(strict_types=1);

use App\Core\App;

require dirname(__DIR__) . '/vendor/autoload.php';

// Start session for auth later
session_start();

// Bootstrap the application (router + controller dispatcher)
$app = new App();
$app->run();
