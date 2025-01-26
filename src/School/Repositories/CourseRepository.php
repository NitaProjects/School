<?php

namespace App\School\Repositories;

use PDO;

class CourseRepository implements CourseRepositoryInterface{
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }


    public function findById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM courses WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function getAll(): array {
        $stmt = $this->db->query("
            SELECT c.id, c.name, c.description, d.name AS department_name 
            FROM courses c
            LEFT JOIN departments d ON c.department_id = d.id
            ORDER BY c.name ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(array $data): void
    {
        $stmt = $this->db->prepare("
            INSERT INTO courses (name, description, department_id) 
            VALUES (:name, :description, :department_id)
        ");
        $stmt->execute([
            'name' => $data['name'],
            'description' => $data['description'],
            'department_id' => $data['department_id'],
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM courses WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}
