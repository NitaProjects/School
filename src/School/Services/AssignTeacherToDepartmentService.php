<?php

namespace App\School\Services;

use App\School\Repositories\TeacherRepository;
use App\School\Repositories\DepartmentRepository;
use App\School\Repositories\AssignmentRepository;
use App\School\Repositories\UserRepository;

class AssignTeacherToDepartmentService
{
    private TeacherRepository $teacherRepository;
    private DepartmentRepository $departmentRepository;
    private AssignmentRepository $assignmentRepository;
    private UserRepository $userRepository;

    public function __construct(
        TeacherRepository $teacherRepository,
        DepartmentRepository $departmentRepository,
        AssignmentRepository $assignmentRepository,
        UserRepository $userRepository
    ) {
        $this->teacherRepository = $teacherRepository;
        $this->departmentRepository = $departmentRepository;
        $this->assignmentRepository = $assignmentRepository;
        $this->userRepository = $userRepository;
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

    public function assignTeacherToDepartment(int $teacherId, int $departmentId): void
    {
        if ($this->assignmentRepository->exists($teacherId, $departmentId)) {
            throw new \Exception("Este profesor ya está asignado a este departamento.");
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
    }

    public function deleteAssignment(int $assignmentId): void
    {
        $assignment = $this->assignmentRepository->findById($assignmentId);
        if (!$assignment) {
            throw new \Exception("Asignación no encontrada.");
        }

        $this->assignmentRepository->delete($assignmentId);
    }

    public function createTeacher(string $name, string $email, string $password, string $hireDate): void
    {
        if ($this->userRepository->existsByEmail($email)) {
            throw new \Exception("Un usuario ya usa este email, pruebe con otro.");
        }

        $userId = $this->userRepository->create($name, $email, $password, "teacher");
        $this->teacherRepository->create($userId, $hireDate);
    }



    public function execute(int $teacherId, int $departmentId): void
{
    if ($this->assignmentRepository->exists($teacherId, $departmentId)) {
        throw new \Exception("Este ya tiene su silla aquí. ¿Intentando clonar profesores?");
    }

    $teacher = $this->teacherRepository->findById($teacherId);
    if (!$teacher) {
        throw new \Exception("Profesor no encontrado");
    }

    $department = $this->departmentRepository->findById($departmentId);
    if (!$department) {
        throw new \Exception("Departamento no encontrado");
    }

    $this->teacherRepository->assignToDepartment($teacherId, $departmentId);
}


}
