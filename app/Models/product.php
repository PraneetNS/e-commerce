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

public function related(?int $categoryId, int $excludeId): array

{
    $sql = "SELECT * FROM products WHERE category_id = :cid AND id != :pid LIMIT 4";
    $stmt = $this->db->prepare($sql);
    $stmt->execute(['cid' => $categoryId, 'pid' => $excludeId]);
    return $stmt->fetchAll();
    if ($categoryId === null) {
    return [];
}

}
public function countProducts(): int
{
    return (int)$this->db->query("SELECT COUNT(*) FROM products")->fetchColumn();
}
public function paginate(int $start, int $limit): array
{
    $sql = "SELECT * FROM products ORDER BY created_at DESC LIMIT :start, :limit";
    $stmt = $this->db->prepare($sql);
    $stmt->bindValue(':start', $start, \PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}
public function filterProducts(?string $min, ?string $max, ?string $sort): array
{
    $sql = "SELECT * FROM products WHERE 1=1";
    $params = [];

    if (!empty($min)) {
        $sql .= " AND price >= :min";
        $params['min'] = $min;
    }

    if (!empty($max)) {
        $sql .= " AND price <= :max";
        $params['max'] = $max;
    }

    if ($sort === "low-high") {
        $sql .= " ORDER BY price ASC";
    } elseif ($sort === "high-low") {
        $sql .= " ORDER BY price DESC";
    } elseif ($sort === "newest") {
        $sql .= " ORDER BY created_at DESC";
    }

    $stmt = $this->db->prepare($sql);
    $stmt->execute($params);

    return $stmt->fetchAll();
}


}