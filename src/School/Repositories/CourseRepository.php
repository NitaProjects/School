<?php

namespace App\School\Repositories;

use App\School\Entities\Course;
use PDO;

class CourseRepository implements CourseRepositoryInterface
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function findById(int $id): ?Course
    {
        $stmt = $this->db->prepare("SELECT * FROM courses WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? $this->mapToEntity($data) : null;
    }

    public function getAll(): array
    {
        $stmt = $this->db->query("
            SELECT c.id, c.name, c.description, c.department_id, d.name AS department_name
            FROM courses c
            LEFT JOIN departments d ON c.department_id = d.id
            ORDER BY c.name ASC
        ");
        $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map([$this, 'mapToEntity'], $courses);
        
    }


    public function create(Course $course): void
    {
        $stmt = $this->db->prepare("
            INSERT INTO courses (name, description, department_id) 
            VALUES (:name, :description, :department_id)
        ");
        $stmt->execute([
            'name' => $course->getName(),
            'description' => $course->getDescription(),
            'department_id' => $course->getDepartmentId(),
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM courses WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }

    private function mapToEntity(array $data): Course
    {
        $course = new Course($data['name'], $data['description'], (int) $data['department_id']);
        $course->setId((int) $data['id']);

        if (isset($data['department_name'])) {
            $course->setDepartmentName($data['department_name']);
        }

        return $course;
    }
}
