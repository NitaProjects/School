<?php

namespace App\School\Repositories;

use App\School\Entities\Department;

use PDO;

class DepartmentRepository implements DepartmentRepositoryInterface
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    private function mapToEntity(array $data): Department
    {
        $department = new Department($data['name'], $data['description']);
        return $department->setId($data['id']);
    }


    public function findById(int $id): ?Department
    {
        $stmt = $this->db->prepare("SELECT * FROM departments WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? $this->mapToEntity($data) : null;
    }


    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT id, name, description FROM departments ORDER BY name ASC");
        $departments = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map([$this, 'mapToEntity'], $departments);
    }

    public function create(Department $department): void
    {
        $stmt = $this->db->prepare("
            INSERT INTO departments (name, description) 
            VALUES (:name, :description)
        ");
        $stmt->execute([
            'name' => $department->getName(),
            'description' => $department->getDescription(),
        ]);
    }

    public function delete(int $id): void
    {
        $stmt = $this->db->prepare("DELETE FROM departments WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }

    public function update(Department $department): void
    {
        $stmt = $this->db->prepare("
            UPDATE departments 
            SET name = :name, description = :description 
            WHERE id = :id
        ");
        $stmt->execute([
            'id' => $department->getId(),
            'name' => $department->getName(),
            'description' => $department->getDescription(),
        ]);
    }
}
