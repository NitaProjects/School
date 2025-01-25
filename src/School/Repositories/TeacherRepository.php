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
    public function findById(int $id, bool $byUserId = false): ?array
    {
        $column = $byUserId ? 'user_id' : 'id'; // Determina la columna a usar
        $stmt = $this->db->prepare("SELECT * FROM teachers WHERE $column = :id");
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
        $stmt = $this->db->query("
        SELECT 
            t.id AS teacher_id,
            u.id AS user_id,
            u.name AS name,
            u.email AS email,
            t.hire_date AS hire_date
        FROM teachers t
        JOIN users u ON t.user_id = u.id
        ORDER BY u.name ASC
    ");
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

    public function hasAssignments(int $teacherId): bool
    {
        $stmt = $this->db->prepare("
        SELECT COUNT(*) FROM assignments WHERE teacher_id = :teacherId
    ");
        $stmt->execute(['teacherId' => $teacherId]);
        return $stmt->fetchColumn() > 0;
    }

    public function deleteUser(int $userId): void
    {
        $stmt = $this->db->prepare("
        DELETE FROM users WHERE id = :userId
    ");
        $stmt->execute(['userId' => $userId]);
    }
}
