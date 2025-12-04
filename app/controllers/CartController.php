<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Product;

class CartController extends Controller
{
    public function index(): void
    {
        $cart = $_SESSION['cart'] ?? [];
        
        $this->view('cart/index', [
            'title' => 'Your Cart',
            'cart' => $cart
        ]);
    }

    public function add(int $productId): void
    {
        $productModel = new Product();
        $product = $productModel->find($productId);

        if (!$product) {
            $_SESSION['error'] = "Product not found";
            $this->redirect('/home/index');
        }

        // Prepare item
        $cartItem = [
            'id'    => $product['id'],
            'name'  => $product['name'],
            'price' => $product['price'],
            'qty'   => 1
        ];

        // Add or Update Quantity
        if (!empty($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['qty']++;
        } else {
            $_SESSION['cart'][$productId] = $cartItem;
        }

        $_SESSION['success'] = "{$product['name']} added to cart";
        $this->redirect('/cart/index');
    }

    public function remove(int $productId): void
    {
        if (!empty($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
        }

        $_SESSION['success'] = "Item removed from cart";
        $this->redirect('/cart/index');
    }

    public function update(int $productId): void
    {
        $qty = intval($_POST['qty'] ?? 1);

        if ($qty <= 0) {
            unset($_SESSION['cart'][$productId]);
        } else {
            $_SESSION['cart'][$productId]['qty'] = $qty;
        }

        $_SESSION['success'] = "Cart updated";
        $this->redirect('/cart/index');
    }
}
