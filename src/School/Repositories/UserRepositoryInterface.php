<?php

namespace App\School\Repositories;

use App\School\Entities\User;

interface UserRepositoryInterface
{
    public function create(User $user): int;

    public function existsByEmail(string $email): bool;

    public function findById(int $id): ?User;

    public function findByTeacherId(int $teacherId): ?User; 

    public function findByStudentId(int $studentId): ?User; 
}
