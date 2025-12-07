<?php
declare(strict_types=1);

namespace App\Controllers;
use App\Models\Category;

use App\Core\Controller;
use App\Models\Product;

class HomeController extends Controller
{
    public function index(): void
{
    $productModel = new Product();
    $products = $productModel->getFeatured(8);

    $catModel = new Category();
    $categories = $catModel->all();

    $this->view('home/index', [
        'products' => $products,
        'categories' => $categories
    ]);
    $page = $_GET['page'] ?? 1;
$limit = 8;
$start = ($page - 1) * $limit;

$products = $productModel->paginate($start, $limit);
$total = $productModel->countProducts();
$pages = ceil($total / $limit);

}


    public function about(): void
    {
        $this->view('home/about', [
            'title' => 'About MyShop',
        ]);
    }
    public function category(int $id): void
{
    $productModel = new Product();
    $products = $productModel->getByCategory($id);

    $catModel = new Category();
    $categories = $catModel->all();

    $this->view('home/index', [
        'products'   => $products,
        'categories' => $categories
    ]);
}
public function filter(): void
{
    $min  = $_GET['min'] ?? null;
    $max  = $_GET['max'] ?? null;
    $sort = $_GET['sort'] ?? null;

    $productModel = new Product();
    $products = $productModel->filterProducts($min, $max, $sort);

    $catModel = new Category();
    $categories = $catModel->all();

    $this->view('home/index', [
        'products' => $products,
        'categories' => $categories
    ]);
}

}
