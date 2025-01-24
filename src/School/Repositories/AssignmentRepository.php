<?php

namespace App\School\Repositories;

use PDO;

class AssignmentRepository {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    /**
     * Obtiene todas las asignaciones (profesores y departamentos).
     */
    public function getAllAssignments(): array {
        $stmt = $this->db->query("
            SELECT 
                a.id AS assignment_id,
                u.name AS teacher_name,
                d.name AS department_name,
                a.assigned_date
            FROM assignments a
            JOIN teachers t ON a.teacher_id = t.id
            JOIN users u ON t.user_id = u.id
            JOIN departments d ON a.department_id = d.id
            ORDER BY a.assigned_date DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete(int $assignmentId): void {
        $stmt = $this->db->prepare("DELETE FROM assignments WHERE id = :id");
        $stmt->execute(['id' => $assignmentId]);
    }
    
    public function findById(int $assignmentId): ?array {
        $stmt = $this->db->prepare("SELECT * FROM assignments WHERE id = :id");
        $stmt->execute(['id' => $assignmentId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function exists(int $teacherId, int $departmentId): bool {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) 
            FROM assignments 
            WHERE teacher_id = :teacher_id AND department_id = :department_id
        ");
        $stmt->execute(['teacher_id' => $teacherId, 'department_id' => $departmentId]);
        return (bool) $stmt->fetchColumn(); 
    }
}
