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

    public function createStudent(string $name, string $email, string $password, string $enrollmentDate): array
    {
        if ($this->userRepository->existsByEmail($email)) {
            throw new \Exception("Email duplicado detectado. ¿También repites contraseñas? 🤔");
        }

        $userId = $this->userRepository->create($name, $email, $password, "student");
        $this->studentRepository->create($userId, $enrollmentDate);

        return [
            'message' => '¡Nuevo recluta listo! Espero que tenga buen aguante.',
        ];
    }

    public function deleteStudent(int $userId): array
    {
        $student = $this->studentRepository->findById($userId, true);
        if (!$student) {
            throw new \Exception("Alumno no encontrado.");
        }

        if ($this->studentRepository->hasEnrollments($student['id'])) {
            throw new \Exception("¡Ni lo sueñes! Este alumno tiene más cursos pendientes que un procrastinador en diciembre.");
        }

        $this->studentRepository->deleteUser($userId);

        return [
            'message' => '¡Eliminado! Esperemos que no regrese pidiendo una beca.',
        ];
    }


    public function getAllStudents(): array
    {
        return $this->studentRepository->getAll();
    }
}
