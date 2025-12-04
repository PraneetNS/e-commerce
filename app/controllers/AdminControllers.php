<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;

class AdminController extends Controller
{
    public function index(): void
    {
        // Simple admin check
        if (empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            $_SESSION['error'] = "Unauthorized access.";
            $this->redirect('/home/index');
        }

        $this->view('admin/dashboard', [
            'title' => 'Admin Dashboard'
        ]);
    }
}
