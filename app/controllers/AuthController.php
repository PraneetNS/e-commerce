<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

class AuthController extends Controller
{
    public function register(): void
    {
        $this->view('auth/register', [
            'title' => 'Register'
        ]);
    }

    public function registerSubmit(): void
    {
        $name     = $_POST['name'] ?? '';
        $email    = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm  = $_POST['confirm_password'] ?? '';

        if (empty($name) || empty($email) || empty($password)) {
            $_SESSION['error'] = "All fields are required.";
            $this->redirect('/auth/register');
        }

        if ($password !== $confirm) {
            $_SESSION['error'] = "Passwords do not match.";
            $this->redirect('/auth/register');
        }

        $userModel = new User();
        $existingUser = $userModel->findByEmail($email);

        if ($existingUser) {
            $_SESSION['error'] = "Email already registered.";
            $this->redirect('/auth/register');
        }

        $userModel->create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'role' => 'customer'
        ]);

        $_SESSION['success'] = "Registration successful. Please login.";
        $this->redirect('/auth/login');
    }

    public function login(): void
    {
        $this->view('auth/login', [
            'title' => 'Login'
        ]);
    }

    public function loginSubmit(): void
    {
        $email    = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $_SESSION['error'] = "Email & password required.";
            $this->redirect('/auth/login');
        }

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            $_SESSION['error'] = "Invalid credentials.";
            $this->redirect('/auth/login');
        }

        $_SESSION['user'] = [
            'id'   => $user['id'],
            'name' => $user['name'],
            'email'=> $user['email'],
            'role' => $user['role']
        ];

        $_SESSION['success'] = "Welcome back, {$user['name']}!";
        $this->redirect('/home/index');
    }

    public function logout(): void
    {
        unset($_SESSION['user']);
        session_destroy();
        $this->redirect('/auth/login');
    }
}
