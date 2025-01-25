<?php

namespace App\School\Repositories;

use PDO;

class StudentRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Encuentra un estudiante por su ID.
     */
    public function findById(int $id, bool $byUserId = false): ?array
    {
        $column = $byUserId ? 'user_id' : 'id'; 
        $stmt = $this->db->prepare("SELECT * FROM students WHERE $column = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Inscribe un estudiante en un curso.
     */
    public function enrollInCourse(int $studentId, int $courseId): void
    {
        $stmt = $this->db->prepare("
            INSERT INTO enrollments (student_id, course_id, enrollment_date)
            VALUES (:student_id, :course_id, NOW())
        ");
        $stmt->execute(['student_id' => $studentId, 'course_id' => $courseId]);
    }

    /**
     * Obtiene todos los estudiantes.
     */
    public function getAll(): array
    {
        $stmt = $this->db->query("
        SELECT 
            t.id AS student_id,
            u.id AS user_id,
            u.name AS name,
            u.email AS email,
            t.enrollment_date AS enrollment_date
        FROM students t
        JOIN users u ON t.user_id = u.id
        ORDER BY u.name ASC
    ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create(int $userId, string $enrollmentDate): void
    {
        $stmt = $this->db->prepare("
        INSERT INTO students (user_id, enrollment_date) 
        VALUES (:user_id, :enrollment_date)
    ");
        $stmt->execute([
            'user_id' => $userId,
            'enrollment_date' => $enrollmentDate
        ]);
    }

    public function hasEnrollments(int $studentId): bool
    {
        $stmt = $this->db->prepare("
        SELECT COUNT(*) FROM enrollments WHERE student_id = :studentId
    ");
        $stmt->execute(['studentId' => $studentId]);
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
