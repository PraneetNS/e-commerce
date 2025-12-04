<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class User extends Model
{
    public function findByEmail(string $email): ?array
    {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['email' => $email]);

        $user = $stmt->fetch();
        return $user === false ? null : $user;
    }

    public function create(array $data): int
    {
        $sql = "INSERT INTO users (name, email, password, role) 
                VALUES (:name, :email, :password, :role)";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'name'     => $data['name'],
            'email'    => $data['email'],
            // Always hash passwords
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'role'     => $data['role'] ?? 'customer',
        ]);

        return (int)$this->db->lastInsertId();
    }

    public function all(): array
    {
        $sql = "SELECT id, name, email, role, created_at FROM users ORDER BY created_at DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
}
