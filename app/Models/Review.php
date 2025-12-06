<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Review extends Model
{
    public function add(int $product, int $user, int $rating, string $review): bool
    {
        $sql = "INSERT INTO reviews (product_id, user_id, rating, review)
                VALUES (:pid, :uid, :rating, :review)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'pid' => $product,
            'uid' => $user,
            'rating' => $rating,
            'review' => $review
        ]);
    }

    public function getByProduct(int $productId): array
    {
        $sql = "SELECT r.*, u.name
                FROM reviews r
                JOIN users u ON r.user_id = u.id
                WHERE product_id = :id
                ORDER BY created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $productId]);
        return $stmt->fetchAll();
    }
}
