<?php

namespace App\School\Services;

use App\School\Repositories\CourseRepositoryInterface;
use App\School\Repositories\EnrollmentRepository;
use App\School\Repositories\DepartmentRepository;


class CourseService
{
    private CourseRepositoryInterface $courseRepository;
    private EnrollmentRepository $enrollmentRepository;
    private DepartmentRepository $departmentRepository;

    public function __construct(
        CourseRepositoryInterface $courseRepository,
        EnrollmentRepository $enrollmentRepository,
        DepartmentRepository $departmentRepository
    ) {
        $this->courseRepository = $courseRepository;
        $this->enrollmentRepository = $enrollmentRepository;
        $this->departmentRepository = $departmentRepository;
    }

    public function createCourse(string $name, string $description, int $departmentId): array
{
    if (empty($name)) {
        throw new \Exception("El nombre del curso no puede estar vacío.");
    }

    $existingCourse = array_filter(
        $this->courseRepository->getAll(),
        fn($course) => $course['name'] === $name
    );

    if ($existingCourse) {
        throw new \Exception("Ya existe un curso con ese nombre. ¡Sé más original!");
    }

    // Verifica si el departamento existe
    $department = $this->departmentRepository->findById($departmentId);
    if (!$department) {
        throw new \Exception("El departamento seleccionado no existe.");
    }

    $this->courseRepository->create([
        'name' => $name,
        'description' => $description,
        'department_id' => $departmentId,
    ]);

    return [
        'message' => "Curso '{$name}' creado exitosamente.",
    ];
}


    public function deleteCourse(int $id): array
    {
        $course = $this->courseRepository->findById($id);

        if (!$course) {
            throw new \Exception("Curso no encontrado. ¿Seguro que no está en un universo paralelo?");
        }

        if ($this->enrollmentRepository->hasEnrollmentsForCourse($id)) {
            throw new \Exception("No se puede eliminar el curso '{$course['name']}' porque tiene inscripciones activas.");
        }

        $this->courseRepository->delete($id);

        return [
            'message' => "El curso '{$course['name']}' ha sido eliminado. Esperemos que haya valido la pena.",
        ];
    }


    public function getAllCourses(): array
    {
        return $this->courseRepository->getAll();
    }
}
