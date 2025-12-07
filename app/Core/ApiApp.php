<?php
declare(strict_types=1);

namespace App\Core;

class ApiApp
{
    protected string $controllerName = 'ApiHomeController';
    protected string $method = 'index';
    protected array $params = [];
    protected object $controller;

    public function __construct()
    {
        $url = $_GET['url'] ?? '';
        $url = trim($url, '/');
        $parts = $url ? explode('/', $url) : [];

        if (!empty($parts[0])) {
            $possible = 'Api' . ucfirst($parts[0]) . 'Controller';
            if (file_exists(__DIR__ . '/../Controllers/' . $possible . '.php')) {
                $this->controllerName = $possible;
                unset($parts[0]);
            }
        }

        $class = 'App\\Controllers\\' . $this->controllerName;
        $this->controller = new $class;

        if (!empty($parts[1]) && method_exists($this->controller, $parts[1])) {
            $this->method = $parts[1];
            unset($parts[1]);
        }

        $this->params = $parts ? array_values($parts) : [];
    }

    public function run(): void
    {
        call_user_func_array([$this->controller, $this->method], $this->params);
    }
}
