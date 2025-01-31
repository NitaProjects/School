<?php

namespace App\School\Repositories;

use App\School\Entities\Teacher;

interface TeacherRepositoryInterface
{
    public function findById(int $id, bool $byUserId = false): ?Teacher;


    public function getAll(): array;

    public function create(Teacher $teacher): void;

    public function assignToDepartment(int $teacherId, int $departmentId): void;

    public function hasAssignments(int $teacherId): bool;

    public function deleteUser(int $userId): void;
}
