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
    Auth::admin();

    $orderModel = new Order();
    $productModel = new Product();
    $userModel = new User();   // <--- FIX

    $stats = [
        'orders'   => $orderModel->countOrders(),
        'revenue'  => $orderModel->totalRevenue(),
        'products' => $productModel->countProducts(),
        'users'    => $userModel->countUsers()
    ];

    $topSelling = $orderModel->topSelling();
    $lowStock   = $orderModel->lowStock();

    $this->view('admin/dashboard', [
        'stats'      => $stats,
        'topSelling' => $topSelling,
        'lowStock'   => $lowStock
    ]);
}

}
