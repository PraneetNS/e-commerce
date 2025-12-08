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
public function countOrders(): int
{
    return (int)$this->db->query("SELECT COUNT(*) FROM orders")->fetchColumn();
}



public function monthlyStats(): array
{
    $sql = "SELECT DATE_FORMAT(created_at, '%b') as month, SUM(total) as revenue
            FROM orders
            WHERE status='paid' OR status='completed'
            GROUP BY MONTH(created_at)";
    $stmt = $this->db->query($sql);
    return $stmt->fetchAll();
}
public function alsoBought(int $productId, int $limit = 4): array
{
    $limit = (int)$limit;

    $sql = "
        SELECT p.*, SUM(oi2.qty) AS total_qty
        FROM order_items oi
        JOIN order_items oi2 ON oi.order_id = oi2.order_id
        JOIN products p ON oi2.product_id = p.id
        WHERE oi.product_id = :pid
          AND oi2.product_id != :pid2
        GROUP BY oi2.product_id
        ORDER BY total_qty DESC
        LIMIT $limit
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(':pid', $productId, \PDO::PARAM_INT);
    $stmt->bindValue(':pid2', $productId, \PDO::PARAM_INT);

    $stmt->execute();

    return $stmt->fetchAll();
}
// Total Revenue
public function totalRevenue(): float
{
    $sql = "SELECT SUM(total) AS revenue FROM orders";
    $stmt = $this->db->query($sql);
    $row = $stmt->fetch();
    return (float)($row['revenue'] ?? 0);
}




// Top Selling Products
public function topSelling(int $limit = 5): array
{
    $sql = "
        SELECT p.name, p.image, SUM(oi.qty) AS total_sold
        FROM order_items oi
        JOIN products p ON oi.product_id = p.id
        GROUP BY oi.product_id
        ORDER BY total_sold DESC
        LIMIT $limit
    ";
    return $this->db->query($sql)->fetchAll();
}

// Low Stock Alerts
public function lowStock(int $limit = 5): array
{
    $sql = "SELECT id, name, stock FROM products WHERE stock < 5 ORDER BY stock ASC LIMIT $limit";
    return $this->db->query($sql)->fetchAll();
}
public function monthlySales(): array
{
    $sql = "
        SELECT DATE_FORMAT(created_at, '%b') AS month,
               SUM(total) AS revenue
        FROM orders
        GROUP BY MONTH(created_at)
        ORDER BY MONTH(created_at)
    ";

    $stmt = $this->db->query($sql);
    return $stmt->fetchAll();
}



}