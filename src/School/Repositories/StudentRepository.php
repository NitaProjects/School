<?php

namespace App\School\Repositories;

use PDO;

class StudentRepository {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    /**
     * Encuentra un estudiante por su ID.
     */
    public function findById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM students WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Inscribe un estudiante en un curso.
     */
    public function enrollInCourse(int $studentId, int $courseId): void {
        $stmt = $this->db->prepare("
            INSERT INTO enrollments (student_id, course_id, enrollment_date)
            VALUES (:student_id, :course_id, NOW())
        ");
        $stmt->execute(['student_id' => $studentId, 'course_id' => $courseId]);
    }

    /**
     * Obtiene todos los estudiantes.
     */
    public function getAll(): array {
        $stmt = $this->db->query("SELECT s.id, u.name 
                                  FROM students s
                                  JOIN users u ON s.user_id = u.id
                                  ORDER BY u.name ASC");
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
}
