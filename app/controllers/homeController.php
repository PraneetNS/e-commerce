<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller
{
    public function index(): void
    {
        $this->view('home/index', [
            'title'   => 'MyShop – Custom PHP E-commerce',
            'message' => 'Your custom MVC skeleton is running 🎉'
        ]);
    }

    // Example extra method: /home/about
    public function about(): void
    {
        $this->view('home/about', [
            'title' => 'About MyShop',
        ]);
    }
}
