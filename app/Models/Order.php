<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Order extends Model
{
    public function createOrder(int $userId, float $total, string $address): int
    {
        $sql = "INSERT INTO orders (user_id, total, address) VALUES (:user_id, :total, :address)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'user_id' => $userId,
            'total' => $total,
            'address' => $address
        ]);

        return (int)$this->db->lastInsertId();
    }

    public function addOrderItem(int $orderId, int $productId, $price, int $qty): void

    {
        $sql = "INSERT INTO order_items (order_id, product_id, price, qty)
                VALUES (:order_id, :product_id, :price, :qty)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'order_id' => $orderId,
            'product_id' => $productId,
            'price' => $price,
            'qty' => $qty
        ]);
    }
}
