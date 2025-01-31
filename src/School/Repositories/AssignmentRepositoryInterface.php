<?php

namespace App\School\Repositories;

use App\School\Entities\Assignment;

interface AssignmentRepositoryInterface
{
    public function getAllAssignments(): array;

    public function findById(int $assignmentId): ?Assignment;

    public function delete(int $assignmentId): void;

    public function exists(int $teacherId, int $departmentId): bool;

    public function hasAssignmentsForDepartment(int $departmentId): bool;
}
