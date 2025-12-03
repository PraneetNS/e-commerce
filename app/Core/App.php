<?php
declare(strict_types=1);

namespace App\Core;

class App
{
    protected $controller = 'HomeController';  //
    protected string $method = 'index';
    protected array $params = [];

    public function __construct()
    {
        $url = $this->parseUrl();

        if (!empty($url[0])) {
            $possibleController = ucfirst($url[0]) . 'Controller';
            $controllerFile = __DIR__ . '/../Controllers/' . $possibleController . '.php';

            if (file_exists($controllerFile)) {
                $this->controller = $possibleController;
                unset($url[0]);
            }
        }

        $controllerClass = 'App\\Controllers\\' . $this->controller;
        $this->controller = new $controllerClass();  // create object

        if (!empty($url[1]) && method_exists($this->controller, $url[1])) {
            $this->method = $url[1];
            unset($url[1]);
        }

        $this->params = $url ? array_values($url) : [];
    }

    public function run(): void
    {
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    protected function parseUrl(): array
    {
        $url = $_GET['url'] ?? '';
        $url = rtrim($url, '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);

        return $url ? explode('/', $url) : [];
    }
}
