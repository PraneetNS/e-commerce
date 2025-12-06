<?php
namespace App\Middleware;

class Auth
{
    public static function check(): void
    {
        if (empty($_SESSION['user'])) {
            $_SESSION['error'] = "Login required";
            header("Location: /ecommerce-mvc/public/auth/login");
            exit;
        }
    }

    public static function admin(): void
    {
        if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            $_SESSION['error'] = "Unauthorized access";
            header("Location: /ecommerce-mvc/public/home/index");
            exit;
        }
    }
}
