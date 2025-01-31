<?php

namespace App\School\Services;

use App\School\Entities\Course;
use App\School\Entities\Department;
use App\School\Repositories\CourseRepositoryInterface;
use App\School\Repositories\EnrollmentRepository;
use App\School\Repositories\DepartmentRepositoryInterface;

class CourseService
{
    private CourseRepositoryInterface $courseRepository;
    private EnrollmentRepository $enrollmentRepository;
    private DepartmentRepositoryInterface $departmentRepository;

    public function __construct(
        CourseRepositoryInterface $courseRepository,
        EnrollmentRepository $enrollmentRepository,
        DepartmentRepositoryInterface $departmentRepository
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
            fn(Course $course) => $course->getName() === $name
        );

        if ($existingCourse) {
            throw new \Exception("Ya existe un curso con ese nombre. ¡Sé más original!");
        }

        // Verifica si el departamento existe
        $department = $this->departmentRepository->findById($departmentId);
        if (!$department instanceof Department) {
            throw new \Exception("El departamento seleccionado no existe.");
        }

        $course = new Course($name, $description, $departmentId);
        $this->courseRepository->create($course);

        return [
            'message' => "Curso '{$name}' creado exitosamente.",
        ];
    }

    public function deleteCourse(int $id): array
    {
        $course = $this->courseRepository->findById($id);

        if (!$course instanceof Course) {
            throw new \Exception("Curso no encontrado. ¿Seguro que no está en un universo paralelo?");
        }

        if ($this->enrollmentRepository->hasEnrollmentsForCourse($course->getId())) {
            throw new \Exception("No se puede eliminar el curso '{$course->getName()}' porque tiene inscripciones activas.");
        }

        $this->courseRepository->delete($id);

        return [
            'message' => "El curso '{$course->getName()}' ha sido eliminado. Esperemos que haya valido la pena.",
        ];
    }

    public function getAllCourses(): array
    {
        return array_map(fn(Course $course) => $this->serialize($course), $this->courseRepository->getAll());
    }

    private function serialize(Course $course): array
    {
        return [
            'id' => $course->getId(),
            'name' => $course->getName(),
            'description' => $course->getDescription(),
            'department_id' => $course->getDepartmentId(),
            'department_name' => $course->getDepartmentName(), 
        ];
    }
}
