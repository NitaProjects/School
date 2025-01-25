<?php

namespace App\School\Services;

use App\School\Repositories\StudentRepository;
use App\School\Repositories\UserRepository;

class StudentService
{
    private StudentRepository $studentRepository;
    private UserRepository $userRepository;

    public function __construct(
        StudentRepository $studentRepository,
        UserRepository $userRepository
    ) {
        $this->studentRepository = $studentRepository;
        $this->userRepository = $userRepository;
    }

    public function createStudent(string $name, string $email, string $password, string $enrollmentDate): void
    {
        if ($this->userRepository->existsByEmail($email)) {
            throw new \Exception("¿En serio? ¿Otro con este email? Invéntate algo más original, haz el favor.");
        }

        $userId = $this->userRepository->create($name, $email, $password, "student");
        $this->studentRepository->create($userId, $enrollmentDate);
    }
}
