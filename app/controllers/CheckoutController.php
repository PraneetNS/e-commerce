<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Order;
use App\Models\Product;

class CheckoutController extends Controller
{
    public function index(): void
    {
        // Require login
        if (empty($_SESSION['user'])) {
            $_SESSION['error'] = "You must login before checkout.";
            $this->redirect('/auth/login');
        }

        $cart = $_SESSION['cart'] ?? [];
        if (empty($cart)) {
            $_SESSION['error'] = "Your cart is empty.";
            $this->redirect('/cart/index');
        }

        $this->view('checkout/index', [
            'title' => 'Checkout',
            'cart' => $cart
        ]);
    }

    public function placeOrder(): void
    {
        if (empty($_SESSION['user'])) {
            $_SESSION['error'] = "Login required.";
            $this->redirect('/auth/login');
        }

        $cart = $_SESSION['cart'] ?? [];
        if (empty($cart)) {
            $_SESSION['error'] = "Cart empty.";
            $this->redirect('/cart/index');
        }

        $address = $_POST['address'] ?? '';
        if (empty($address)) {
            $_SESSION['error'] = "Address is required.";
            $this->redirect('/checkout/index');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['qty'];
        }

        $orderModel = new Order();
        $orderId = $orderModel->createOrder($_SESSION['user']['id'], $total, $address);

        foreach ($cart as $item) {
            $orderModel->addOrderItem($orderId, $item['id'], $item['price'], $item['qty']);
        }

        unset($_SESSION['cart']);

        $_SESSION['success'] = "Order placed successfully! Order ID: $orderId";
        $this->redirect('/checkout/success');
    }

    public function success(): void
    {
        $this->view('checkout/success', ['title' => 'Order Success']);
    }
}
