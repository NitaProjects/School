<?php

namespace App\School\Repositories;

use App\School\Entities\Teacher;
use PDO;

class TeacherRepository implements TeacherRepositoryInterface
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function findById(int $id, bool $byUserId = false): ?Teacher
    {
        $column = $byUserId ? 'user_id' : 'id'; 
        $stmt = $this->db->prepare("
            SELECT 
                t.id AS teacher_id, 
                u.id AS user_id, 
                u.name, 
                u.email, 
                t.hire_date
            FROM teachers t 
            JOIN users u ON t.user_id = u.id 
            WHERE t.$column = :id
        ");
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $data ? $this->mapToEntity($data) : null; // 🔹 Devuelve un `Teacher` en lugar de un array
    }
    



public function getAll(): array
{
    $stmt = $this->db->query("
        SELECT 
            t.id AS teacher_id, 
            u.id AS user_id, 
            u.name, 
            u.email, 
            t.hire_date
        FROM teachers t
        JOIN users u ON t.user_id = u.id
        ORDER BY u.name ASC
    ");
    $teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return array_map([$this, 'mapToEntity'], $teachers); // 🔹 Convertir a objetos Teacher
}



    public function create(Teacher $teacher): void
    {
        $stmt = $this->db->prepare("
            INSERT INTO teachers (user_id, hire_date) 
            VALUES (:user_id, :hire_date)
        ");
        $stmt->execute([
            'user_id' => $teacher->getId(),
            'hire_date' => $teacher->getHireDate(),
        ]);
    }

    public function assignToDepartment(int $teacherId, int $departmentId): void
    {
        $stmt = $this->db->prepare("
            INSERT INTO assignments (teacher_id, department_id, assigned_date)
            VALUES (:teacher_id, :department_id, NOW())
        ");
        $stmt->execute(['teacher_id' => $teacherId, 'department_id' => $departmentId]);
    }

    public function hasAssignments(int $teacherId): bool
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM assignments WHERE teacher_id = :teacherId");
        $stmt->execute(['teacherId' => $teacherId]);
        return $stmt->fetchColumn() > 0;
    }

    public function deleteUser(int $userId): void
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :userId");
        $stmt->execute(['userId' => $userId]);
    }
    

    private function mapToEntity(array $data): Teacher
{
    $teacher = new Teacher(
        $data['name'],
        $data['email'],
        '', 
        'teacher',
        $data['hire_date']
    );
    
    $teacher->setId((int) $data['teacher_id']); 
    return $teacher;
}

}
