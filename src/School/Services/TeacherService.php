<?php

namespace App\School\Services;

use App\School\Repositories\TeacherRepository;
use App\School\Repositories\UserRepository;

class TeacherService
{
    private TeacherRepository $teacherRepository;
    private UserRepository $userRepository;

    public function __construct(
        TeacherRepository $teacherRepository,
        UserRepository $userRepository
    ) {
        $this->teacherRepository = $teacherRepository;
        $this->userRepository = $userRepository;
    }

    public function createTeacher(string $name, string $email, string $password, string $hireDate): void
    {
        if ($this->userRepository->existsByEmail($email)) {
            throw new \Exception("¿En serio? ¿Otro con este email? Invéntate algo más original, haz el favor.");
        }

        $userId = $this->userRepository->create($name, $email, $password, "teacher");
        $this->teacherRepository->create($userId, $hireDate);
    }
}
