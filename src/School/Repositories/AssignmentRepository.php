<?php

namespace App\School\Repositories;

use App\School\Entities\Assignment;
use App\School\Entities\Teacher;
use App\School\Entities\Department;
use PDO;

class AssignmentRepository implements AssignmentRepositoryInterface
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAllAssignments(): array
    {
        $stmt = $this->db->query("
            SELECT 
                a.id AS assignment_id,
                t.id AS teacher_id,
                u.name AS teacher_name,
                u.email AS teacher_email,
                d.id AS department_id,
                d.name AS department_name,
                a.assigned_date
            FROM assignments a
            JOIN teachers t ON a.teacher_id = t.id
            JOIN users u ON t.user_id = u.id
            JOIN departments d ON a.department_id = d.id
            ORDER BY a.assigned_date DESC
        ");
        $assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map([$this, 'mapToEntity'], $assignments);
    }

    public function findById(int $assignmentId): ?Assignment
    {
        $stmt = $this->db->prepare("
            SELECT 
                a.id AS assignment_id,
                t.id AS teacher_id,
                u.name AS teacher_name,
                u.email AS teacher_email,
                d.id AS department_id,
                d.name AS department_name,
                a.assigned_date
            FROM assignments a
            JOIN teachers t ON a.teacher_id = t.id
            JOIN users u ON t.user_id = u.id
            JOIN departments d ON a.department_id = d.id
            WHERE a.id = :id
        ");
        $stmt->execute(['id' => $assignmentId]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? $this->mapToEntity($data) : null;
    }

    public function delete(int $assignmentId): void
    {
        $stmt = $this->db->prepare("DELETE FROM assignments WHERE id = :id");
        $stmt->execute(['id' => $assignmentId]);
    }

    public function exists(int $teacherId, int $departmentId): bool
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) 
            FROM assignments 
            WHERE teacher_id = :teacher_id AND department_id = :department_id
        ");
        $stmt->execute(['teacher_id' => $teacherId, 'department_id' => $departmentId]);
        return (bool) $stmt->fetchColumn();
    }

    public function hasAssignmentsForDepartment(int $departmentId): bool
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) 
            FROM assignments 
            WHERE department_id = :departmentId
        ");
        $stmt->execute(['departmentId' => $departmentId]);
        return $stmt->fetchColumn() > 0;
    }

    private function mapToEntity(array $data): Assignment
    {
        $teacher = new Teacher(
            $data['teacher_name'],
            $data['teacher_email'],
            '', // Contraseña no disponible en esta consulta
            'teacher',
            '' // Fecha de contratación no disponible en esta consulta
        );
        $teacher->setId((int) $data['teacher_id']);

        $department = new Department($data['department_name'], '');
        $department->setId((int) $data['department_id']);

        $assignment = new Assignment($teacher, $department, $data['assigned_date']);
        return $assignment->setId((int) $data['assignment_id']);
    }
}
