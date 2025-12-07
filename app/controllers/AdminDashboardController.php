<?php
declare(strict_types=1);

namespace App\Controllers;
use App\Middleware\Auth;



use App\Core\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function __construct()
{
    Auth::admin();
}
    public function index(): void
    {
        if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            $_SESSION['error'] = "Unauthorized";
            $this->redirect('/home/index');
        }

        $orderModel = new Order();
        $productModel = new Product();
        $userModel = new User();

        $stats = [
            'orders'   => $orderModel->countOrders(),
            'revenue'  => $orderModel->totalRevenue(),
            'products' => $productModel->countProducts(),
            'users'    => $userModel->countUsers(),
            'chartData' => $orderModel->monthlyStats()
        ];

        $this->view('admin/dashboard', [
            'stats' => $stats
        ]);
    }
}
