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

    public function addOrderItem(int $orderId, int $productId, float $price, int $qty): void
{
    $stmt = $this->db->prepare("INSERT INTO order_items (order_id, product_id, price, qty) VALUES (:oid, :pid, :price, :qty)");
    $stmt->execute([
        'oid' => $orderId,
        'pid' => $productId,
        'price' => $price,
        'qty' => $qty
    ]);

    // Decrease stock
    $stockUpdate = $this->db->prepare("UPDATE products SET stock = stock - :qty WHERE id = :pid");
    $stockUpdate->execute(['qty' => $qty, 'pid' => $productId]);
}

    public function getOrdersByUser(int $userId): array
{
    $sql = "SELECT * FROM orders WHERE user_id = :uid ORDER BY created_at DESC";
    $stmt = $this->db->prepare($sql);
    $stmt->execute(['uid' => $userId]);
    return $stmt->fetchAll();
}

public function getOrderDetail(int $id): ?array
{
    $sql = "SELECT o.*, u.name, u.email 
            FROM orders o
            JOIN users u ON o.user_id = u.id
            WHERE o.id = :id";

    $stmt = $this->db->prepare($sql);
    $stmt->execute(['id' => $id]);
    $order = $stmt->fetch();

    if (!$order) return null;

    $sql = "SELECT oi.*, p.name AS product_name
            FROM order_items oi
            JOIN products p ON oi.product_id = p.id
            WHERE oi.order_id = :id";

    $stmt = $this->db->prepare($sql);
    $stmt->execute(['id' => $id]);
    $items = $stmt->fetchAll();

    $order['items'] = $items;
    return $order;
}
public function getAllOrders(): array
{
    $sql = "SELECT o.*, u.name, u.email
            FROM orders o
            JOIN users u ON o.user_id = u.id
            ORDER BY o.created_at DESC";
    $stmt = $this->db->query($sql);
    return $stmt->fetchAll();
}

public function updateStatus(int $id, string $status): bool
{
    $sql = "UPDATE orders SET status = :status WHERE id = :id";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute(['id' => $id, 'status' => $status]);
}
public function markPaid(int $orderId, string $paymentId): bool
{
    $sql = "UPDATE orders SET status='paid', payment_id=:pid WHERE id=:id";
    $stmt = $this->db->prepare($sql);
    return $stmt->execute([
        'pid' => $paymentId,
        'id'  => $orderId
    ]);
}

}
