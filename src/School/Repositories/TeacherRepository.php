<?php

namespace App\School\Repositories;

use PDO;

class TeacherRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Encuentra un profesor por su ID.
     */
    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM teachers WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Asigna un profesor a un departamento.
     */
    public function assignToDepartment(int $teacherId, int $departmentId): void
    {
        $stmt = $this->db->prepare("
            INSERT INTO assignments (teacher_id, department_id, assigned_date)
            VALUES (:teacher_id, :department_id, NOW())
        ");
        $stmt->execute(['teacher_id' => $teacherId, 'department_id' => $departmentId]);
    }

    /**
     * Obtiene todos los profesores.
     */
    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT t.id, u.name 
                                  FROM teachers t
                                  JOIN users u ON t.user_id = u.id
                                  ORDER BY u.name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(int $userId, string $hireDate): void
    {
        $stmt = $this->db->prepare("
        INSERT INTO teachers (user_id, hire_date) 
        VALUES (:user_id, :hire_date)
    ");
        $stmt->execute([
            'user_id' => $userId,
            'hire_date' => $hireDate
        ]);
    }
}
