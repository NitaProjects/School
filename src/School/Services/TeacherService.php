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

    public function createTeacher(string $name, string $email, string $password, string $hireDate): array
    {
        if ($this->userRepository->existsByEmail($email)) {
            throw new \Exception("Ese email ya tiene dueño, amigo. ¿Es tan difícil ser único?");
        }

        $userId = $this->userRepository->create($name, $email, $password, "teacher");
        $this->teacherRepository->create($userId, $hireDate);

        return [
            'message' => '¡Bam! Otro profe al sistema. A ver cuánto dura.',
        ];
    }

    public function deleteTeacher(int $userId): array
    {
        $teacher = $this->teacherRepository->findById($userId, true);
        if (!$teacher) {
            throw new \Exception("Profesor no encontrado.");
        }

        if ($this->teacherRepository->hasAssignments($teacher['id'])) {
            throw new \Exception("Lo sentimos, el profe tiene su 'residencia fija' en algún departamento.");
        }

        $this->teacherRepository->deleteUser($userId);

        return [
            'message' => 'Se fue. Que lo recuerden los que quieran... nosotros seguimos adelante.',
        ];
    }

    public function getAllTeachers(): array
    {
        return $this->teacherRepository->getAll();
    }
}
