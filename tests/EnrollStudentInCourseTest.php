<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\School\Services\EnrollStudentInCourseService;
use App\School\Repositories\StudentRepository;
use App\School\Repositories\CourseRepository;
use App\School\Repositories\EnrollmentRepository;
use App\School\Repositories\UserRepository;

class EnrollStudentInCourseTest extends TestCase
{
    private $service;
    private $studentRepository;
    private $courseRepository;
    private $enrollmentRepository;
    private $userRepository;

    protected function setUp(): void
    {
        $this->studentRepository = $this->createMock(StudentRepository::class);
        $this->courseRepository = $this->createMock(CourseRepository::class);
        $this->enrollmentRepository = $this->createMock(EnrollmentRepository::class);
        $this->userRepository = $this->createMock(UserRepository::class);

        $this->service = new EnrollStudentInCourseService(
            $this->studentRepository,
            $this->courseRepository,
            $this->enrollmentRepository,
            $this->userRepository
        );
    }

    public function testEnrollStudentSuccessfully(): void
    {
        $studentId = 1;
        $courseId = 1;

        $this->enrollmentRepository
            ->method('exists')
            ->with($studentId, $courseId)
            ->willReturn(false);

        $this->studentRepository
            ->method('findById')
            ->with($studentId)
            ->willReturn(['id' => $studentId, 'name' => 'Test Student']);

        $this->courseRepository
            ->method('findById')
            ->with($courseId)
            ->willReturn(['id' => $courseId, 'name' => 'Test Course']);

        $this->enrollmentRepository
            ->expects($this->once())
            ->method('enrollStudent')
            ->with($studentId, $courseId);

        $this->service->execute($studentId, $courseId);
    }

    public function testEnrollStudentFailsWhenAlreadyEnrolled(): void
    {
        $studentId = 1;
        $courseId = 1;

        $this->enrollmentRepository
            ->method('exists')
            ->with($studentId, $courseId)
            ->willReturn(true);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Este alumno ya está matriculado en este curso.");

        $this->service->execute($studentId, $courseId);
    }

    /**
     * Caso de éxito: Eliminar una inscripción correctamente.
     */
    public function testDeleteEnrollmentSuccessfully(): void
    {
        $enrollmentId = 1;

        $this->enrollmentRepository
            ->method('findById')
            ->with($enrollmentId)
            ->willReturn(['id' => $enrollmentId, 'student_id' => 1, 'course_id' => 1]);

        $this->enrollmentRepository
            ->expects($this->once())
            ->method('delete')
            ->with($enrollmentId);

        $this->service->deleteEnrollment($enrollmentId);
    }

    /**
     * Caso de error: La inscripción no existe.
     */
    public function testDeleteEnrollmentFailsWhenNotFound(): void
    {
        $enrollmentId = 999;

        $this->enrollmentRepository
            ->method('findById')
            ->with($enrollmentId)
            ->willReturn(null);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Inscripción no encontrada.");

        $this->service->deleteEnrollment($enrollmentId);
    }
}
