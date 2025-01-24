<?php

namespace App\School\Services;

use App\School\Repositories\StudentRepository;
use App\School\Repositories\CourseRepository;
use App\School\Repositories\EnrollmentRepository;
use App\School\Repositories\UserRepository;

class EnrollStudentInCourseService
{
    private StudentRepository $studentRepository;
    private CourseRepository $courseRepository;
    private EnrollmentRepository $enrollmentRepository;
    private UserRepository $userRepository;

    public function __construct(
        StudentRepository $studentRepository,
        CourseRepository $courseRepository,
        EnrollmentRepository $enrollmentRepository,
        UserRepository $userRepository
    ) {
        $this->studentRepository = $studentRepository;
        $this->courseRepository = $courseRepository;
        $this->enrollmentRepository = $enrollmentRepository;
        $this->userRepository = $userRepository;
    }

    public function getAllStudents(): array
    {
        return $this->studentRepository->getAll();
    }

    public function getAllCourses(): array
    {
        return $this->courseRepository->getAll();
    }

    public function getEnrollments(): array
    {
        return $this->enrollmentRepository->getAllEnrollments();
    }

    public function enrollStudentInCourse(int $studentId, int $courseId): void
    {
        if ($this->enrollmentRepository->exists($studentId, $courseId)) {
            throw new \Exception("Este alumno ya está matriculado en este curso.");
        }

        $student = $this->studentRepository->findById($studentId);
        if (!$student) {
            throw new \Exception("Estudiante no encontrado.");
        }

        $course = $this->courseRepository->findById($courseId);
        if (!$course) {
            throw new \Exception("Curso no encontrado.");
        }

        $this->enrollmentRepository->enrollStudent($studentId, $courseId);
    }

    public function deleteEnrollment(int $enrollmentId): void
    {
        $enrollment = $this->enrollmentRepository->findById($enrollmentId);
        if (!$enrollment) {
            throw new \Exception("Inscripción no encontrada.");
        }

        $this->enrollmentRepository->delete($enrollmentId);
    }

    public function createStudent(string $name, string $email, string $password, string $enrollmentDate): void
    {
        if ($this->userRepository->existsByEmail($email)) {
            throw new \Exception("Un usuario ya usa este email, pruebe con otro.");
        }

        $userId = $this->userRepository->create($name, $email, $password, "student");
        $this->studentRepository->create($userId, $enrollmentDate);
    }

    public function execute(int $studentId, int $courseId): void
{
    if ($this->enrollmentRepository->exists($studentId, $courseId)) {
        throw new \Exception("Este alumno ya está matriculado en este curso.");
    }

    $student = $this->studentRepository->findById($studentId);
    if (!$student) {
        throw new \Exception("Estudiante no encontrado");
    }

    $course = $this->courseRepository->findById($courseId);
    if (!$course) {
        throw new \Exception("Curso no encontrado");
    }

    $this->enrollmentRepository->enrollStudent($studentId, $courseId);
}

}
