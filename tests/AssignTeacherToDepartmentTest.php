<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\School\Services\AssignTeacherToDepartmentService;
use App\School\Repositories\TeacherRepository;
use App\School\Repositories\DepartmentRepository;
use App\School\Repositories\AssignmentRepository;
use App\School\Repositories\UserRepository;
use App\School\Entities\Teacher;
use App\School\Entities\Department;
use App\School\Entities\Assignment;

class AssignTeacherToDepartmentTest extends TestCase
{
    private $service;
    private $teacherRepository;
    private $departmentRepository;
    private $assignmentRepository;
    private $userRepository;

    protected function setUp(): void
    {
        $this->teacherRepository = $this->createMock(TeacherRepository::class);
        $this->departmentRepository = $this->createMock(DepartmentRepository::class);
        $this->assignmentRepository = $this->createMock(AssignmentRepository::class);
        $this->userRepository = $this->createMock(UserRepository::class);

        $this->service = new AssignTeacherToDepartmentService(
            $this->teacherRepository,
            $this->departmentRepository,
            $this->assignmentRepository
        );
    }

    /**
     * Caso de éxito: asignar un profesor a un departamento.
     */
    public function testAssignTeacherSuccessfully(): void
    {
        $teacherId = 1;
        $departmentId = 1;

        // Simular que no existe la asignación
        $this->assignmentRepository
            ->method('exists')
            ->with($teacherId, $departmentId)
            ->willReturn(false);

        // Simular que el profesor existe
        $teacher = new Teacher('Test Teacher', 'test@example.com', '', 'teacher', '');
        $teacher->setId($teacherId);

        $this->teacherRepository
            ->method('findById')
            ->with($teacherId)
            ->willReturn($teacher);

        // Simular que el departamento existe
        $department = new Department('Test Department', 'Descripción de prueba');
        $department->setId($departmentId);

        $this->departmentRepository
            ->method('findById')
            ->with($departmentId)
            ->willReturn($department);

        // Asegurarse de que el método de asignar se llama exactamente una vez
        $this->teacherRepository
            ->expects($this->once())
            ->method('assignToDepartment')
            ->with($teacherId, $departmentId);

        // Ejecutar la asignación
        $this->service->assignTeacherToDepartment($teacherId, $departmentId);
    }

    /**
     * Caso de error: el profesor ya está asignado al departamento.
     */
    public function testAssignTeacherFailsWhenAlreadyAssigned(): void
    {
        $teacherId = 1;
        $departmentId = 1;

        // Simular que la asignación ya existe
        $this->assignmentRepository
            ->method('exists')
            ->with($teacherId, $departmentId)
            ->willReturn(true);

        // Asegurar que se lanza la excepción esperada
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("El departamento ya le mandó flores de bienvenida, ¿qué más quieres?");

        $this->service->assignTeacherToDepartment($teacherId, $departmentId);
    }

    /**
     * Caso de error: el profesor no existe.
     */
    public function testAssignTeacherFailsWhenTeacherNotFound(): void
    {
        $teacherId = 1;
        $departmentId = 1;

        // Simular que no existe la asignación
        $this->assignmentRepository
            ->method('exists')
            ->with($teacherId, $departmentId)
            ->willReturn(false);

        // Simular que el profesor no existe
        $this->teacherRepository
            ->method('findById')
            ->with($teacherId)
            ->willReturn(null);

        // Asegurar que se lanza la excepción esperada
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Profesor no encontrado.");

        $this->service->assignTeacherToDepartment($teacherId, $departmentId);
    }

    /**
     * Caso de error: el departamento no existe.
     */
    public function testAssignTeacherFailsWhenDepartmentNotFound(): void
    {
        $teacherId = 1;
        $departmentId = 1;

        // Simular que no existe la asignación
        $this->assignmentRepository
            ->method('exists')
            ->with($teacherId, $departmentId)
            ->willReturn(false);

        // Simular que el profesor existe
        $teacher = new Teacher('Test Teacher', 'test@example.com', '', 'teacher', '');
        $teacher->setId($teacherId);

        $this->teacherRepository
            ->method('findById')
            ->with($teacherId)
            ->willReturn($teacher);

        // Simular que el departamento no existe
        $this->departmentRepository
            ->method('findById')
            ->with($departmentId)
            ->willReturn(null);

        // Asegurar que se lanza la excepción esperada
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Departamento no encontrado.");

        $this->service->assignTeacherToDepartment($teacherId, $departmentId);
    }

    /**
     * Caso de éxito: eliminar una asignación.
     */
    public function testDeleteAssignmentSuccessfully(): void
    {
        $assignmentId = 1;

        // Simular una asignación existente
        $teacher = new Teacher('Test Teacher', 'test@example.com', '', 'teacher', '');
        $teacher->setId(1);

        $department = new Department('Test Department', 'Descripción de prueba');
        $department->setId(1);

        $assignment = new Assignment($teacher, $department, '2025-01-29');
        $assignment->setId($assignmentId);

        $this->assignmentRepository
            ->method('findById')
            ->with($assignmentId)
            ->willReturn($assignment);

        // Asegurarse de que el método delete se llama exactamente una vez
        $this->assignmentRepository
            ->expects($this->once())
            ->method('delete')
            ->with($assignmentId);

        // Ejecutar la eliminación
        $this->service->deleteAssignment($assignmentId);
    }

    /**
     * Caso de error: intentar eliminar una asignación inexistente.
     */
    public function testDeleteAssignmentFailsWhenNotFound(): void
    {
        $assignmentId = 999;

        // Simular que la asignación no existe
        $this->assignmentRepository
            ->method('findById')
            ->with($assignmentId)
            ->willReturn(null);

        // Asegurar que se lanza la excepción esperada
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Asignación no encontrada.");

        // Ejecutar la eliminación
        $this->service->deleteAssignment($assignmentId);
    }
}
