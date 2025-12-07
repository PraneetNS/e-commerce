<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Middleware\Auth;
use App\Models\Product;

class AdminProductController extends Controller
{
    public function __construct()
    {
        Auth::admin();
    }

    public function index(): void
    {
        $productModel = new Product();
        $products = $productModel->getAll();

        $this->view('admin/products/index', [
            'products' => $products
        ]);
    }

    // Create, Store, Edit, Update, Delete methods go here...
}
