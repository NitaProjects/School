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

    public function enrollStudentInCourse(int $studentId, int $courseId): array
    {
        if ($this->enrollmentRepository->exists($studentId, $courseId)) {
            throw new \Exception("¡Ya está matriculado! No repitas como loro.");
        }

        $student = $this->studentRepository->findById($studentId);
        if (!$student) {
            throw new \Exception("Estudiante no encontrado. ¿Es un fantasma o qué?");
        }

        $course = $this->courseRepository->findById($courseId);
        if (!$course) {
            throw new \Exception("Curso no encontrado. ¿Acaso estás inventando nombres?");
        }

        $this->enrollmentRepository->enrollStudent($studentId, $courseId);

        return [
            'message' => "¡Hecho! El estudiante está atrapado en {$course['name']}... ¡ya no puede escapar! 😈",
        ];
    }



    public function deleteEnrollment(int $enrollmentId): array
    {
        $enrollment = $this->enrollmentRepository->findById($enrollmentId);
        if (!$enrollment) {
            throw new \Exception("Matricula no encontrada.");
        }

        $this->enrollmentRepository->delete($enrollmentId);

        return [
            'message' => 'Alumno eliminado del curso. Quizás lo piense mejor la próxima vez.'
        ];
    }
}
