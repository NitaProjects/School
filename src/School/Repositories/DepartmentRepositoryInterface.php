<?php

namespace App\School\Repositories;

interface DepartmentRepositoryInterface
{
    public function findById(int $id): ?array;

    public function getAll(): array;

    public function create(array $data): void;

    public function delete(int $id): void;

    public function update(int $id, array $data): void;
}
