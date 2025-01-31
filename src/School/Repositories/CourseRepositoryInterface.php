<?php

namespace App\School\Repositories;

use App\School\Entities\Course;

interface CourseRepositoryInterface
{
    public function getAll(): array;
    
    public function findById(int $id): ?Course;

    public function create(Course $course): void;

    public function delete(int $id): void;
}
