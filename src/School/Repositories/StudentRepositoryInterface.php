<?php

namespace App\School\Repositories;

use App\School\Entities\Student;

interface StudentRepositoryInterface
{
    public function getAll(): array;
    
    public function findById(int $id, bool $byUserId = false): ?Student;

    public function create(Student $student): void;

    public function enrollInCourse(int $studentId, int $courseId): void;

    public function hasEnrollments(int $studentId): bool;

    public function deleteUser(int $userId): void;
}
