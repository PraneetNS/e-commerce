<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Product extends Model
{
    public function getAll(): array
    {
        $sql = "SELECT p.*, c.name AS category_name
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.id
                ORDER BY p.created_at DESC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function getFeatured(int $limit = 8): array
    {
        $sql = "SELECT p.*, c.name AS category_name
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.id
                WHERE p.is_featured = 1
                ORDER BY p.created_at DESC
                LIMIT :limit";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $sql = "SELECT p.*, c.name AS category_name
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.id
                WHERE p.id = :id LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);

        $product = $stmt->fetch();
        return $product === false ? null : $product;
    }
    public function createProduct(array $data): int
{
    $sql = "INSERT INTO products (name, price, stock, description, is_featured, image, created_at)
            VALUES (:name, :price, :stock, :description, :is_featured, :image, NOW())";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([
        'name' => $data['name'],
        'price' => $data['price'],
        'stock' => $data['stock'],
        'description' => $data['description'],
        'is_featured' => $data['is_featured'],
        'image' => $data['image']
    ]);

    return (int)$this->db->lastInsertId();
}
public function updateProduct(int $id, array $data): bool
{
    $sql = "UPDATE products SET name=:name, price=:price, stock=:stock,
            description=:description, is_featured=:is_featured, image=:image,
            updated_at = NOW() WHERE id=:id";

    $stmt = $this->db->prepare($sql);
    return $stmt->execute([
        'id' => $id,
        'name' => $data['name'],
        'price' => $data['price'],
        'stock' => $data['stock'],
        'description' => $data['description'],
        'is_featured' => $data['is_featured'],
        'image' => $data['image']
    ]);
}

public function deleteProduct(int $id): bool
{
    $stmt = $this->db->prepare("DELETE FROM products WHERE id = :id");
    return $stmt->execute(['id' => $id]);

}
public function getByCategory(int $categoryId): array
{
    $sql = "SELECT * FROM products WHERE category_id = :cid ORDER BY created_at DESC";
    $stmt = $this->db->prepare($sql);
    $stmt->execute(['cid' => $categoryId]);
    return $stmt->fetchAll();
}

}