<?php

namespace App\School\Services;

use App\School\Entities\Student;
use App\School\Entities\Course;
use App\School\Entities\Enrollment;
use App\School\Repositories\StudentRepositoryInterface;
use App\School\Repositories\CourseRepositoryInterface;
use App\School\Repositories\EnrollmentRepositoryInterface;

class EnrollStudentInCourseService
{
    private StudentRepositoryInterface $studentRepository;
    private CourseRepositoryInterface $courseRepository;
    private EnrollmentRepositoryInterface $enrollmentRepository;

    public function __construct(
        StudentRepositoryInterface $studentRepository,
        CourseRepositoryInterface $courseRepository,
        EnrollmentRepositoryInterface $enrollmentRepository
    ) {
        $this->studentRepository = $studentRepository;
        $this->courseRepository = $courseRepository;
        $this->enrollmentRepository = $enrollmentRepository;
    }

    public function getAllStudents(): array
    {
        return array_map(fn(Student $student) => $this->serializeStudent($student), $this->studentRepository->getAll());
    }

    public function getAllCourses(): array
    {
        return array_map(fn(Course $course) => $this->serializeCourse($course), $this->courseRepository->getAll());
    }

    public function getEnrollments(): array
    {
        return array_map(fn(Enrollment $enrollment) => $this->serializeEnrollment($enrollment), $this->enrollmentRepository->getAllEnrollments());
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

        $enrollment = new Enrollment($student, $course, date('Y-m-d'));
        $this->enrollmentRepository->enrollStudent($enrollment);

        return [
            'message' => "¡Hecho! El estudiante está atrapado en {$course->getName()}... ¡ya no puede escapar! 😈",
        ];
    }

    public function deleteEnrollment(int $enrollmentId): array
    {
        $enrollment = $this->enrollmentRepository->findById($enrollmentId);
        if (!$enrollment) {
            throw new \Exception("Matrícula no encontrada.");
        }

        $this->enrollmentRepository->delete($enrollmentId);

        return [
            'message' => 'Alumno eliminado del curso. Quizás lo piense mejor la próxima vez.',
        ];
    }

    private function serializeStudent(Student $student): array
    {
        return [
            'student_id' => $student->getId(),
            'name' => $student->getName(),
            'email' => $student->getEmail(),
            'enrollment_date' => $student->getEnrollmentDate(),
        ];
    }

    private function serializeCourse(Course $course): array
    {
        return [
            'course_id' => $course->getId(),
            'name' => $course->getName(),
            'description' => $course->getDescription(),
            'department_id' => $course->getDepartmentId(),
        ];
    }

    private function serializeEnrollment(Enrollment $enrollment): array
    {
        return [
            'enrollment_id' => $enrollment->getId(),
            'student_id' => $enrollment->getStudent()->getId(),
            'student_name' => $enrollment->getStudent()->getName(),
            'course_id' => $enrollment->getCourse()->getId(),
            'course_name' => $enrollment->getCourse()->getName(),
            'enrollment_date' => $enrollment->getEnrollmentDate(),
        ];
    }
}
