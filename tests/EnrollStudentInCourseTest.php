<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\School\Services\EnrollStudentInCourseService;
use App\School\Repositories\StudentRepository;
use App\School\Repositories\CourseRepository;
use App\School\Repositories\EnrollmentRepository;
use App\School\Entities\Student;
use App\School\Entities\Course;
use App\School\Entities\Enrollment;


class EnrollStudentInCourseTest extends TestCase
{
    private $service;
    private $studentRepository;
    private $courseRepository;
    private $enrollmentRepository;

    protected function setUp(): void
    {
        $this->studentRepository = $this->createMock(StudentRepository::class);
        $this->courseRepository = $this->createMock(CourseRepository::class);
        $this->enrollmentRepository = $this->createMock(EnrollmentRepository::class);

        $this->service = new EnrollStudentInCourseService(
            $this->studentRepository,
            $this->courseRepository,
            $this->enrollmentRepository
        );
    }

    /**
     * Caso de éxito: Matricular un estudiante en un curso.
     */
    public function testEnrollStudentSuccessfully(): void
{
    $studentId = 1;
    $courseId = 1;

    // Crear objetos en lugar de arrays
    $student = new Student("Test Student", "test@student.com", "password", "Student", "2023-09-01");
    $student->setId($studentId);

    $course = new Course("Test Course", "Descripción del curso", 1);
    $course->setId($courseId);

    // Simular que no existe la inscripción
    $this->enrollmentRepository
        ->method('exists')
        ->with($studentId, $courseId)
        ->willReturn(false);

    // Simular que el estudiante existe
    $this->studentRepository
        ->method('findById')
        ->with($studentId)
        ->willReturn($student);

    // Simular que el curso existe
    $this->courseRepository
        ->method('findById')
        ->with($courseId)
        ->willReturn($course);

    // Verificar que se llama a enrollStudent con un objeto `Enrollment`
    $this->enrollmentRepository
        ->expects($this->once())
        ->method('enrollStudent')
        ->with($this->callback(function ($enrollment) use ($studentId, $courseId) {
            return $enrollment instanceof Enrollment &&
                   $enrollment->getStudent()->getId() === $studentId &&
                   $enrollment->getCourse()->getId() === $courseId;
        }));

    // Ejecutar el método
    $this->service->enrollStudentInCourse($studentId, $courseId);
}


    /**
     * Caso de error: El estudiante ya está matriculado.
     */
    public function testEnrollStudentFailsWhenAlreadyEnrolled(): void
    {
        $studentId = 1;
        $courseId = 1;

        // Simular que ya existe la inscripción
        $this->enrollmentRepository
            ->method('exists')
            ->with($studentId, $courseId)
            ->willReturn(true);

        // Verificar que se lanza la excepción esperada
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("¡Ya está matriculado! No repitas como loro.");

        // Ejecutar el método
        $this->service->enrollStudentInCourse($studentId, $courseId);
    }

    /**
     * Caso de éxito: Eliminar una inscripción correctamente.
     */
    public function testDeleteEnrollmentSuccessfully(): void
{
    $enrollmentId = 1;

    // Crear objetos en lugar de arrays
    $student = new Student("Test Student", "test@student.com", "password", "Student", "2023-09-01");
    $student->setId(1);

    $course = new Course("Test Course", "Descripción del curso", 1);
    $course->setId(1);

    $enrollment = new Enrollment($student, $course, "2024-01-01");
    $enrollment->setId($enrollmentId);

    // Simular que la inscripción existe
    $this->enrollmentRepository
        ->method('findById')
        ->with($enrollmentId)
        ->willReturn($enrollment);

    // Verificar que se llama al método delete
    $this->enrollmentRepository
        ->expects($this->once())
        ->method('delete')
        ->with($enrollmentId);

    // Ejecutar el método
    $this->service->deleteEnrollment($enrollmentId);
}


    /**
     * Caso de error: Intentar eliminar una inscripción inexistente.
     */
    public function testDeleteEnrollmentFailsWhenNotFound(): void
    {
        $enrollmentId = 999;

        // Simular que la inscripción no existe
        $this->enrollmentRepository
            ->method('findById')
            ->with($enrollmentId)
            ->willReturn(null);

        // Verificar que se lanza la excepción esperada
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Matrícula no encontrada.");

        // Ejecutar el método
        $this->service->deleteEnrollment($enrollmentId);
    }
}