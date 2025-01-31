<?php

namespace App\School\Repositories;

use App\School\Entities\Student;
use PDO;

class StudentRepository implements StudentRepositoryInterface
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function findById(int $id, bool $byUserId = false): ?Student
    {
        $column = $byUserId ? 'user_id' : 'id';
        $stmt = $this->db->prepare("
            SELECT 
                s.id AS student_id, 
                u.id AS user_id, 
                u.name, 
                u.email, 
                s.enrollment_date
            FROM students s
            JOIN users u ON s.user_id = u.id
            WHERE s.$column = :id
        ");
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? $this->mapToEntity($data) : null;
    }

    public function getAll(): array
    {
        $stmt = $this->db->query("
            SELECT 
                s.id AS student_id, 
                u.id AS user_id, 
                u.name, 
                u.email, 
                s.enrollment_date
            FROM students s
            JOIN users u ON s.user_id = u.id
            ORDER BY u.name ASC
        ");
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map([$this, 'mapToEntity'], $students);
    }

    public function create(Student $student): void
    {
        $stmt = $this->db->prepare("
            INSERT INTO students (user_id, enrollment_date) 
            VALUES (:user_id, :enrollment_date)
        ");
        $stmt->execute([
            'user_id' => $student->getId(),
            'enrollment_date' => $student->getEnrollmentDate(),
        ]);
    }

    public function enrollInCourse(int $studentId, int $courseId): void
    {
        $stmt = $this->db->prepare("
            INSERT INTO enrollments (student_id, course_id, enrollment_date)
            VALUES (:student_id, :course_id, NOW())
        ");
        $stmt->execute(['student_id' => $studentId, 'course_id' => $courseId]);
    }

    public function hasEnrollments(int $studentId): bool
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM enrollments WHERE student_id = :studentId");
        $stmt->execute(['studentId' => $studentId]);
        return $stmt->fetchColumn() > 0;
    }

    public function deleteUser(int $userId): void
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :userId");
        $stmt->execute(['userId' => $userId]);
    }

    private function mapToEntity(array $data): Student
    {
        $student = new Student(
            $data['name'],
            $data['email'],
            '', 
            'student',
            $data['enrollment_date']
        );
        return $student->setId((int) $data['student_id']);
    }
}
