<?php

namespace App\School\Repositories;

use App\School\Entities\Enrollment;
use App\School\Entities\Student;
use App\School\Entities\Course;
use PDO;

class EnrollmentRepository implements EnrollmentRepositoryInterface
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function enrollStudent(Enrollment $enrollment): void
    {
        $stmt = $this->db->prepare("
            INSERT INTO enrollments (student_id, course_id, enrollment_date)
            VALUES (:student_id, :course_id, :enrollment_date)
        ");
        $stmt->execute([
            'student_id' => $enrollment->getStudent()->getId(),
            'course_id' => $enrollment->getCourse()->getId(),
            'enrollment_date' => $enrollment->getEnrollmentDate(),
        ]);
    }

    public function getEnrollmentsByStudent(int $studentId): array
    {
        $stmt = $this->db->prepare("
            SELECT e.id AS enrollment_id, c.id AS course_id, c.name AS course_name, e.enrollment_date
            FROM enrollments e
            JOIN courses c ON e.course_id = c.id
            WHERE e.student_id = :student_id
            ORDER BY e.enrollment_date DESC
        ");
        $stmt->execute(['student_id' => $studentId]);
        $enrollments = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map([$this, 'mapToEntity'], $enrollments);
    }

    public function getAllEnrollments(): array
    {
        $stmt = $this->db->query("
            SELECT 
                e.id AS enrollment_id,
                s.id AS student_id,
                u.name AS student_name,
                u.email AS student_email,
                c.id AS course_id,
                c.name AS course_name,
                e.enrollment_date
            FROM enrollments e
            JOIN students s ON e.student_id = s.id
            JOIN users u ON s.user_id = u.id
            JOIN courses c ON e.course_id = c.id
            ORDER BY e.enrollment_date DESC
        ");
        $enrollments = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map([$this, 'mapToEntity'], $enrollments);
    }

    public function findById(int $enrollmentId): ?Enrollment
    {
        $stmt = $this->db->prepare("
            SELECT 
                e.id AS enrollment_id,
                s.id AS student_id,
                u.name AS student_name,
                u.email AS student_email,
                c.id AS course_id,
                c.name AS course_name,
                e.enrollment_date
            FROM enrollments e
            JOIN students s ON e.student_id = s.id
            JOIN users u ON s.user_id = u.id
            JOIN courses c ON e.course_id = c.id
            WHERE e.id = :id
        ");
        $stmt->execute(['id' => $enrollmentId]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? $this->mapToEntity($data) : null;
    }

    public function delete(int $enrollmentId): void
    {
        $stmt = $this->db->prepare("DELETE FROM enrollments WHERE id = :id");
        $stmt->execute(['id' => $enrollmentId]);
    }

    public function exists(int $studentId, int $courseId): bool
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) 
            FROM enrollments 
            WHERE student_id = :student_id AND course_id = :course_id
        ");
        $stmt->execute(['student_id' => $studentId, 'course_id' => $courseId]);
        return (bool) $stmt->fetchColumn();
    }

    public function hasEnrollmentsForCourse(int $courseId): bool
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) 
            FROM enrollments 
            WHERE course_id = :courseId
        ");
        $stmt->execute(['courseId' => $courseId]);
        return $stmt->fetchColumn() > 0;
    }

    private function mapToEntity(array $data): Enrollment
    {
        $student = new Student(
            $data['student_name'],
            $data['student_email'],
            '', // Contraseña no disponible
            'student',
            $data['enrollment_date']
        );
        $student->setId((int) $data['student_id']);

        $course = new Course($data['course_name'], '', (int) $data['course_id']);
        $course->setId((int) $data['course_id']);

        $enrollment = new Enrollment($student, $course, $data['enrollment_date']);
        return $enrollment->setId((int) $data['enrollment_id']);
    }
}
