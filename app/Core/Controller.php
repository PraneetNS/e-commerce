<?php
declare(strict_types=1);

namespace App\Core;

abstract class Controller
{
    public function view(string $view, array $data = []): void
{
    extract($data);

    ob_start(); 
    require dirname(__DIR__) . "/Views/$view.php";
    $content = ob_get_clean();

    require dirname(__DIR__) . "/Views/layouts/main.php";
}


    // For including partials inside layouts if needed
    protected function renderPartial(string $view, array $data = []): void
    {
        extract($data);
        $viewFile = __DIR__ . '/../Views/' . $view . '.php';

        if (!file_exists($viewFile)) {
            throw new \RuntimeException("Partial view '{$view}' not found.");
        }

        require $viewFile;
    }

   protected function redirect(string $url): void
{
    $config = require dirname(__DIR__, 2) . '/config/config.php';
    $baseUrl = rtrim($config['app']['base_url'], '/');
    header('Location: ' . $baseUrl . $url);
    exit;
}



    protected function json(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
