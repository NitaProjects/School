<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\School\Services\EnrollStudentInCourseService;
use App\School\Repositories\StudentRepository;
use App\School\Repositories\CourseRepository;
use App\School\Repositories\EnrollmentRepository;

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

        // Simular que no existe la inscripción
        $this->enrollmentRepository
            ->method('exists')
            ->with($studentId, $courseId)
            ->willReturn(false);

        // Simular que el estudiante existe
        $this->studentRepository
            ->method('findById')
            ->with($studentId)
            ->willReturn(['id' => $studentId, 'name' => 'Test Student']);

        // Simular que el curso existe
        $this->courseRepository
            ->method('findById')
            ->with($courseId)
            ->willReturn(['id' => $courseId, 'name' => 'Test Course']);

        // Verificar que se llama a enrollStudent
        $this->enrollmentRepository
            ->expects($this->once())
            ->method('enrollStudent')
            ->with($studentId, $courseId);

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
        $this->expectExceptionMessage("¡Tranquilo, ya está matriculado! No lo atosigues.");

        // Ejecutar el método
        $this->service->enrollStudentInCourse($studentId, $courseId);
    }

    /**
     * Caso de éxito: Eliminar una inscripción correctamente.
     */
    public function testDeleteEnrollmentSuccessfully(): void
    {
        $enrollmentId = 1;

        // Simular que la inscripción existe
        $this->enrollmentRepository
            ->method('findById')
            ->with($enrollmentId)
            ->willReturn(['id' => $enrollmentId, 'student_id' => 1, 'course_id' => 1]);

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
        $this->expectExceptionMessage("Inscripción no encontrada.");

        // Ejecutar el método
        $this->service->deleteEnrollment($enrollmentId);
    }
}
