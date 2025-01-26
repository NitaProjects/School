<?php

namespace App\School\Repositories;

interface CourseRepositoryInterface
{
    public function findById(int $id): ?array;

    public function getAll(): array;

    public function create(array $data): void;

    public function delete(int $id): void;
}
