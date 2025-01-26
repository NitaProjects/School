<?php

namespace App\School\Services;

use App\School\Repositories\TeacherRepository;
use App\School\Repositories\DepartmentRepository;
use App\School\Repositories\AssignmentRepository;

class AssignTeacherToDepartmentService
{
    private TeacherRepository $teacherRepository;
    private DepartmentRepository $departmentRepository;
    private AssignmentRepository $assignmentRepository;

    public function __construct(
        TeacherRepository $teacherRepository,
        DepartmentRepository $departmentRepository,
        AssignmentRepository $assignmentRepository
    ) {
        $this->teacherRepository = $teacherRepository;
        $this->departmentRepository = $departmentRepository;
        $this->assignmentRepository = $assignmentRepository;
    }

    public function getAllTeachers(): array
    {
        return $this->teacherRepository->getAll();
    }

    public function getAllDepartments(): array
    {
        return $this->departmentRepository->getAll();
    }

    public function getAssignments(): array
    {
        return $this->assignmentRepository->getAllAssignments();
    }

    public function assignTeacherToDepartment(int $teacherId, int $departmentId): array
    {
        if ($this->assignmentRepository->exists($teacherId, $departmentId)) {
            throw new \Exception("El departamento ya le mandó flores de bienvenida, ¿qué más quieres?");
        }

        $teacher = $this->teacherRepository->findById($teacherId);
        if (!$teacher) {
            throw new \Exception("Profesor no encontrado.");
        }

        $department = $this->departmentRepository->findById($departmentId);
        if (!$department) {
            throw new \Exception("Departamento no encontrado.");
        }

        $this->teacherRepository->assignToDepartment($teacherId, $departmentId);

        return [
            'message' => 'Asignado al departamento. Que no olvide traer galletas al equipo.'
        ];
    }

    public function deleteAssignment(int $assignmentId): array
    {
        $assignment = $this->assignmentRepository->findById($assignmentId);
        if (!$assignment) {
            throw new \Exception("Asignación no encontrada.");
        }

        $this->assignmentRepository->delete($assignmentId);

        return [
            'message' => 'El profesor ha sido expulsado del departamento. ¿Se lo merecía? Probablemente.'
        ];
    }
}
