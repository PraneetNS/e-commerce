<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

class Category extends Model
{
    public function all(): array
    {
        $stmt = $this->db->query("SELECT * FROM categories ORDER BY name ASC");
        return $stmt->fetchAll();
    }
}
