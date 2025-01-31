<?php

namespace App\School\Services;

use App\School\Entities\Teacher;
use App\School\Entities\Department;
use App\School\Entities\Assignment;
use App\School\Repositories\TeacherRepositoryInterface;
use App\School\Repositories\DepartmentRepositoryInterface;
use App\School\Repositories\AssignmentRepositoryInterface;

class AssignTeacherToDepartmentService
{
    private TeacherRepositoryInterface $teacherRepository;
    private DepartmentRepositoryInterface $departmentRepository;
    private AssignmentRepositoryInterface $assignmentRepository;

    public function __construct(
        TeacherRepositoryInterface $teacherRepository,
        DepartmentRepositoryInterface $departmentRepository,
        AssignmentRepositoryInterface $assignmentRepository
    ) {
        $this->teacherRepository = $teacherRepository;
        $this->departmentRepository = $departmentRepository;
        $this->assignmentRepository = $assignmentRepository;
    }

    public function getAllTeachers(): array
    {
        return array_map(fn(Teacher $teacher) => $this->serializeTeacher($teacher), $this->teacherRepository->getAll());
    }

    public function getAllDepartments(): array
    {
        return array_map(fn(Department $department) => $this->serializeDepartment($department), $this->departmentRepository->getAll());
    }

    public function getAssignments(): array
    {
        return array_map(fn(Assignment $assignment) => $this->serializeAssignment($assignment), $this->assignmentRepository->getAllAssignments());
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

    private function serializeTeacher(Teacher $teacher): array
    {
        return [
            'teacher_id' => $teacher->getId(),
            'name' => $teacher->getName()
        ];
    }

    private function serializeDepartment(Department $department): array
    {
        return [
            'id' => $department->getId(),
            'name' => $department->getName()
        ];
    }

    private function serializeAssignment(Assignment $assignment): array
{
    return [
        'assignment_id' => $assignment->getId(),
        'teacher_id' => $assignment->getTeacher()->getId(),
        'teacher_name' => $assignment->getTeacher()->getName(),
        'department_id' => $assignment->getDepartment()->getId(),
        'department_name' => $assignment->getDepartment()->getName(),
        'assigned_date' => $assignment->getAssignedDate(),
    ];
}
}
