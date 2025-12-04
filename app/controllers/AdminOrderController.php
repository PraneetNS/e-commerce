<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Order;

class AdminOrderController extends Controller
{
    public function index(): void
    {
        if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            $_SESSION['error'] = "Unauthorized.";
            $this->redirect('/home/index');
        }

        $orderModel = new Order();
        $orders = $orderModel->getAllOrders();

        $this->view('admin/orders/index', [
            'title'  => 'Manage Orders',
            'orders' => $orders
        ]);
    }

    public function updateStatus(): void
    {
        if ($_SESSION['user']['role'] !== 'admin') {
            $_SESSION['error'] = "Unauthorized.";
            $this->redirect('/home/index');
        }

        $orderId = (int)($_POST['order_id'] ?? 0);
        $status = $_POST['status'] ?? '';

        if ($orderId === 0 || empty($status)) {
            $_SESSION['error'] = "Invalid update.";
            $this->redirect('/admin/orders/index');
        }

        $orderModel = new Order();
        $orderModel->updateStatus($orderId, $status);

        $_SESSION['success'] = "Order status updated.";
        $this->redirect('/admin/orders/index');
    }
}
