<?php

namespace App\School\Repositories;

use App\School\Entities\Department;

interface DepartmentRepositoryInterface
{
    public function getAll(): array;

    public function findById(int $id): ?Department;

    public function create(Department $department): void;

    public function update(Department $department): void;

    public function delete(int $id): void;
}
