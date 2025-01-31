<?php

namespace App\School\Repositories;

use App\School\Entities\Enrollment;

interface EnrollmentRepositoryInterface
{
    public function enrollStudent(Enrollment $enrollment): void;

    public function getEnrollmentsByStudent(int $studentId): array;

    public function getAllEnrollments(): array;

    public function findById(int $enrollmentId): ?Enrollment;

    public function delete(int $enrollmentId): void;

    public function exists(int $studentId, int $courseId): bool;

    public function hasEnrollmentsForCourse(int $courseId): bool;
}
