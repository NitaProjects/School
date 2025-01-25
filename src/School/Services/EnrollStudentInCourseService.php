<?php

namespace App\School\Services;

use App\School\Repositories\StudentRepository;
use App\School\Repositories\CourseRepository;
use App\School\Repositories\EnrollmentRepository;

class EnrollStudentInCourseService
{
    private StudentRepository $studentRepository;
    private CourseRepository $courseRepository;
    private EnrollmentRepository $enrollmentRepository;

    public function __construct(
        StudentRepository $studentRepository,
        CourseRepository $courseRepository,
        EnrollmentRepository $enrollmentRepository
    ) {
        $this->studentRepository = $studentRepository;
        $this->courseRepository = $courseRepository;
        $this->enrollmentRepository = $enrollmentRepository;
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
            throw new \Exception("¡Tranquilo, ya está matriculado! No lo atosigues.");
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
}
