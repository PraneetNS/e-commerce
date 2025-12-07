<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class ApiAuthController extends Controller
{
    private string $jwtKey = 'super-secret-key-change-this';

    public function login(): void
    {
        $input = json_decode(file_get_contents('php://input'), true) ?? [];
        $email = $input['email'] ?? '';
        $password = $input['password'] ?? '';

        $userModel = new User();
        $user = $userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Invalid credentials']);
            return;
        }

        $payload = [
            'sub' => $user['id'],
            'name' => $user['name'],
            'role' => $user['role'],
            'exp' => time() + 3600
        ];

        $jwt = JWT::encode($payload, $this->jwtKey, 'HS256');
        echo json_encode(['token' => $jwt]);
    }

    /**
     * Helper for other api controllers
     */
    public function verifyToken(string $token): ?array
    {
        try {
            $decoded = JWT::decode($token, new Key($this->jwtKey, 'HS256'));
            return (array)$decoded;
        } catch (\Throwable $e) {
            return null;
        }
    }
}
