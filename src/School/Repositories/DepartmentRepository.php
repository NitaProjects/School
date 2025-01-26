<?php

namespace App\School\Repositories;

use PDO;

class DepartmentRepository implements DepartmentRepositoryInterface
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM departments WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT id, name, description FROM departments ORDER BY name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(array $data): void
    {
        $stmt = $this->db->prepare("
            INSERT INTO departments (name, description) 
            VALUES (:name, :description)
        ");
        $stmt->execute([
            'name' => $data['name'],
            'description' => $data['description'],
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM departments WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}
