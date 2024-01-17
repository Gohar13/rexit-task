<?php

declare(strict_types=1);

namespace RexIt\Task\Repository;

class CategoryRepository extends BaseRepository
{
    public function getAll(): array
    {
        $query = "SELECT id, name FROM categories";
        $stmt = $this->db->query($query);

        $categories = [];
        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $categories[$row['id']] = $row['name'];
        }

        return $categories;
    }

    public function insert(array $categories): void
    {
        $quotedCategories = array_map(function($category) {
            return '(' . $this->db->quote($category) . ')';
        }, $categories);

        $query = "INSERT INTO categories (name) VALUES ";
        $query .= implode(',', $quotedCategories);
        $this->db->query($query);
    }

    public function getCategoryNameById($categoryId)
    {
        $categories = $this->getAll();

        return $categories[$categoryId];
    }
}