<?php

namespace App\School\Services;

use App\School\Entities\Department;
use App\School\Repositories\DepartmentRepositoryInterface;
use App\School\Repositories\AssignmentRepository;

class DepartmentService
{
    private DepartmentRepositoryInterface $departmentRepository;
    private AssignmentRepository $assignmentRepository;

    public function __construct(
        DepartmentRepositoryInterface $departmentRepository,
        AssignmentRepository $assignmentRepository
    ) {
        $this->departmentRepository = $departmentRepository;
        $this->assignmentRepository = $assignmentRepository;
    }

    /**
     * Crea un nuevo departamento.
     */
    public function createDepartment(string $name, string $description): array
    {
        if (empty($name)) {
            throw new \Exception("El nombre del departamento no puede estar vacío.");
        }

        // Comprobamos si ya existe un departamento con el mismo nombre
        $existingDepartment = array_filter(
            $this->departmentRepository->getAll(),
            fn(Department $department) => $department->getName() === $name
        );

        if ($existingDepartment) {
            throw new \Exception("Ya existe un departamento con ese nombre. ¡Sé más original!");
        }

        $department = new Department($name, $description);
        $this->departmentRepository->create($department);

        return [
            'message' => "Departamento '{$name}' creado exitosamente. ¡El primer paso hacia la gloria académica!",
        ];
    }

    public function deleteDepartment(int $id): array
    {
        $department = $this->departmentRepository->findById($id);

        if (!$department) {
            throw new \Exception("Departamento no encontrado. ¿Estás seguro de que existe?");
        }

        if ($this->assignmentRepository->hasAssignmentsForDepartment($id)) {
            throw new \Exception("El departamento '{$department->getName()}' tiene asignaciones. Limpia el desorden antes de intentar borrarlo.");
        }

        $this->departmentRepository->delete($id);

        return [
            'message' => "El departamento '{$department->getName()}' ha sido eliminado. Esperemos que no lo echen de menos.",
        ];
    }


    public function updateDepartment(int $id, string $name, string $description): array
    {
        $department = $this->departmentRepository->findById($id);

        if (!$department) {
            throw new \Exception("Departamento no encontrado. ¿Estás seguro de que existe?");
        }

        if (empty($name)) {
            throw new \Exception("El nombre del departamento no puede estar vacío.");
        }

        $existingDepartment = array_filter(
            $this->departmentRepository->getAll(),
            fn(Department $department) => $department->getName() === $name && $department->getId() !== $id
        );

        if ($existingDepartment) {
            throw new \Exception("Ya existe un departamento con ese nombre. ¡Sé más original!");
        }

        $department->setName($name)->setDescription($description);
        $this->departmentRepository->update($department);

        return [
            'message' => "El departamento '{$name}' ha sido actualizado exitosamente. ¡Un cambio para el futuro!",
        ];
    }

    public function getAllDepartments(): array
    {
        return array_map(fn(Department $department) => $this->serialize($department), $this->departmentRepository->getAll());
    }


    public function getDepartmentById(int $id): array
    {
        $department = $this->departmentRepository->findById($id);

        if (!$department) {
            throw new \Exception("Departamento no encontrado.");
        }

        return $this->serialize($department);
    }

    private function serialize(Department $department): array
    {
        return [
            'id' => $department->getId(),
            'name' => $department->getName(),
            'description' => $department->getDescription(),
        ];
    }
}
