<?php

namespace App\School\Services;

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
            fn($department) => $department['name'] === $name
        );

        if ($existingDepartment) {
            throw new \Exception("Ya existe un departamento con ese nombre. ¡Sé más original!");
        }

        $this->departmentRepository->create([
            'name' => $name,
            'description' => $description,
        ]);

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
            throw new \Exception("El departamento '{$department['name']}' tiene asignaciones. Limpia el desorden antes de intentar borrarlo.");
        }

        $this->departmentRepository->delete($id);

        return [
            'message' => "El departamento '{$department['name']}' ha sido eliminado. Esperemos que no lo echen de menos.",
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
            fn($d) => $d['name'] === $name && $d['id'] !== $id
        );

        if ($existingDepartment) {
            throw new \Exception("Ya existe un departamento con ese nombre. ¡Sé más original!");
        }

        $this->departmentRepository->update($id, [
            'name' => $name,
            'description' => $description,
        ]);

        return [
            'message' => "El departamento '{$name}' ha sido actualizado exitosamente. ¡Un cambio para el futuro!",
        ];
    }

    public function getAllDepartments(): array
    {
        return $this->departmentRepository->getAll();
    }

    public function getDepartmentById(int $id): array
    {
        $department = $this->departmentRepository->findById($id);

        if (!$department) {
            throw new \Exception("Departamento no encontrado.");
        }

        return $department;
    }
}
