<?php

namespace App\School\Repositories;

use PDO;

class EnrollmentRepository {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    /**
     * Inserta una nueva matrícula.
     */
    public function enrollStudent(int $studentId, int $courseId): void {
        $stmt = $this->db->prepare("
            INSERT INTO enrollments (student_id, course_id, enrollment_date)
            VALUES (:student_id, :course_id, NOW())
        ");
        $stmt->execute([
            'student_id' => $studentId,
            'course_id' => $courseId,
        ]);
    }

    /**
     * Obtiene las matrículas de un estudiante específico.
     */
    public function getEnrollmentsByStudent(int $studentId): array {
        $stmt = $this->db->prepare("
            SELECT e.id AS enrollment_id, c.name AS course_name, e.enrollment_date
            FROM enrollments e
            JOIN courses c ON e.course_id = c.id
            WHERE e.student_id = :student_id
            ORDER BY e.enrollment_date DESC
        ");
        $stmt->execute(['student_id' => $studentId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene todas las inscripciones actuales.
     */
    public function getAllEnrollments(): array {
        $stmt = $this->db->query("
            SELECT 
                e.id AS enrollment_id,
                u.name AS student_name,
                c.name AS course_name,
                e.enrollment_date
            FROM enrollments e
            JOIN students s ON e.student_id = s.id
            JOIN users u ON s.user_id = u.id
            JOIN courses c ON e.course_id = c.id
            ORDER BY e.enrollment_date DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete(int $enrollmentId): void {
        $stmt = $this->db->prepare("DELETE FROM enrollments WHERE id = :id");
        $stmt->execute(['id' => $enrollmentId]);
    }
    
    public function findById(int $enrollmentId): ?array {
        $stmt = $this->db->prepare("SELECT * FROM enrollments WHERE id = :id");
        $stmt->execute(['id' => $enrollmentId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function exists(int $studentId, int $courseId): bool {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) 
            FROM enrollments 
            WHERE student_id = :student_id AND course_id = :course_id
        ");
        $stmt->execute(['student_id' => $studentId, 'course_id' => $courseId]);
        return (bool) $stmt->fetchColumn(); 
    }
}
