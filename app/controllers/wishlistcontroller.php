<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Product;

class WishlistController extends Controller
{
    public function index(): void
    {
        $wishlist = $_SESSION['wishlist'] ?? [];
        $this->view('wishlist/index', ['wishlist' => $wishlist]);
    }

    public function add(int $productId): void
    {
        $productModel = new Product();
        $product = $productModel->find($productId);

        if (!$product) {
            $_SESSION['error'] = "Product not found";
            $this->redirect('/home/index');
        }

        $_SESSION['wishlist'][$productId] = $product;
        $_SESSION['success'] = "Product added to wishlist";
        $this->redirect('/wishlist/index');
    }

    public function remove(int $productId): void
    {
        unset($_SESSION['wishlist'][$productId]);
        $_SESSION['success'] = "Removed from wishlist";
        $this->redirect('/wishlist/index');
    }
}
