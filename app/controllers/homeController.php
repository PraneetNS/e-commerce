<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Product;

class HomeController extends Controller
{
    public function index(): void
    {
        $productModel = new Product();
        $featuredProducts = $productModel->getFeatured(4);

        $this->view('home/index', [
            'title'   => 'MyShop – Custom PHP E-commerce',
            'message' => 'Your custom MVC with DB is running 🎉',
            'products' => $featuredProducts,
        ]);
    }

    public function about(): void
    {
        $this->view('home/about', [
            'title' => 'About MyShop',
        ]);
    }
}
