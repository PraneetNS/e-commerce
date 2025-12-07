<?php
declare(strict_types=1);

namespace App\Core;

class ApiApp
{
    protected string $controller = 'ApiHomeController';
    protected string $method = 'index';
    protected array $params = [];

    public function __construct()
    {
        $url = $_GET['url'] ?? '';
        $url = trim($url, '/');
        $urlParts = $url ? explode('/', $url) : [];

        if (!empty($urlParts[0])) {
            $possible = 'Api' . ucfirst($urlParts[0]) . 'Controller';
            if (file_exists(__DIR__ . '/../Controllers/' . $possible . '.php')) {
                $this->controller = $possible;
                unset($urlParts[0]);
            }
        }

        $controllerClass = 'App\\Controllers\\' . $this->controller;
        $this->controller = new $controllerClass();

        if (!empty($urlParts[1]) && method_exists($this->controller, $urlParts[1])) {
            $this->method = $urlParts[1];
            unset($urlParts[1]);
        }

        $this->params = $urlParts ? array_values($urlParts) : [];
    }

    public function run(): void
    {
        header('Content-Type: application/json');
        call_user_func_array([$this->controller, $this->method], $this->params);
    }
}
