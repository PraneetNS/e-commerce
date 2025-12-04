<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Order;

class OrdersController extends Controller
{
    public function index(): void
    {
        if (empty($_SESSION['user'])) {
            $_SESSION['error'] = "Login to view your orders.";
            $this->redirect('/auth/login');
        }

        $orderModel = new Order();
        $orders = $orderModel->getOrdersByUser($_SESSION['user']['id']);

        $this->view('orders/index', [
            'title'  => 'My Orders',
            'orders' => $orders
        ]);
    }

    public function details(int $orderId): void

    {
        if (empty($_SESSION['user'])) {
            $_SESSION['error'] = "Login required.";
            $this->redirect('/auth/login');
        }

        $orderModel = new Order();
        $order = $orderModel->getOrderDetail($orderId);

        if (!$order) {
            $_SESSION['error'] = "Order not found.";
            $this->redirect('/orders/index');
        }

        $this->view('orders/view', [
            'title'  => 'Order Details',
            'order'  => $order
        ]);
    }
}
