<?php

namespace App\School\Repositories;

use PDO;

class CourseRepository {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    /**
     * Encuentra un curso por su ID.
     */
    public function findById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM courses WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Obtiene todos los cursos.
     */
    public function getAll(): array {
        $stmt = $this->db->query("
            SELECT c.id, c.name, c.description, d.name AS department_name 
            FROM courses c
            LEFT JOIN departments d ON c.department_id = d.id
            ORDER BY c.name ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
