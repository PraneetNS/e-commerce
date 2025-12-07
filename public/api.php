<?php
declare(strict_types=1);

use App\Core\ApiApp;

require dirname(__DIR__) . '/vendor/autoload.php';

session_start();

$app = new ApiApp();
$app->run();
