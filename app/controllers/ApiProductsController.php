<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Product;

class ApiProductController extends Controller
{
    public function index(): void
    {
        $productModel = new Product();
        $products = $productModel->getAll();

        echo json_encode($products);
    }

    public function show(int $id): void
    {
        $productModel = new Product();
        $product = $productModel->find($id);

        if (!$product) {
            http_response_code(404);
            echo json_encode(['error' => 'Not found']);
            return;
        }

        echo json_encode($product);
    }
}
