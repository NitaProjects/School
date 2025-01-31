<?php

namespace App\School\Services;

use App\School\Entities\Student;
use App\School\Entities\User;
use App\School\Repositories\StudentRepositoryInterface;
use App\School\Repositories\UserRepositoryInterface;

class StudentService
{
    private StudentRepositoryInterface $studentRepository;
    private UserRepositoryInterface $userRepository;

    public function __construct(
        StudentRepositoryInterface $studentRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->studentRepository = $studentRepository;
        $this->userRepository = $userRepository;
    }

    public function createStudent(string $name, string $email, string $password, string $enrollmentDate): array
    {
        if ($this->userRepository->existsByEmail($email)) {
            throw new \Exception("Email duplicado detectado. ¿También repites contraseñas? 🤔");
        }

        // Crear usuario y obtener su ID
        $user = new User($name, $email, $password, "student");
        $userId = $this->userRepository->create($user);

        // Crear objeto `Student`
        $student = new Student($name, $email, $password, "student", $enrollmentDate);
        $student->setId($userId);

        // Guardar estudiante en la base de datos
        $this->studentRepository->create($student);

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

        if ($this->studentRepository->hasEnrollments($student->getId())) {
            throw new \Exception("¡Ni lo sueñes! Este alumno tiene más cursos pendientes que un procrastinador en diciembre.");
        }

        $this->studentRepository->deleteUser($userId);

        return [
            'message' => '¡Eliminado! Esperemos que no regrese pidiendo una beca.',
        ];
    }

    public function enrollStudentInCourse(int $studentId, int $courseId): array
    {
        $student = $this->studentRepository->findById($studentId);
        if (!$student) {
            throw new \Exception("Alumno no encontrado.");
        }

        $this->studentRepository->enrollInCourse($studentId, $courseId);

        return [
            'message' => "El estudiante {$student->getName()} ha sido inscrito en el curso correctamente.",
        ];
    }

    public function getAllStudents(): array
    {
        return array_map(fn(Student $student) => $this->serialize($student), $this->studentRepository->getAll());
    }

    private function serialize(Student $student): array
    {
        $user = $this->userRepository->findByStudentId($student->getId());

        return [
            'student_id' => $student->getId(),
            'user_id' => $user ? $user->getId() : null,
            'name' => $student->getName(),
            'email' => $student->getEmail(),
            'enrollment_date' => $student->getEnrollmentDate(),
        ];
    }
}
