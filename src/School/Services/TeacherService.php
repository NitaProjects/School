<?php

namespace App\School\Services;

use App\School\Entities\Teacher;
use App\School\Entities\User;
use App\School\Repositories\TeacherRepositoryInterface;
use App\School\Repositories\UserRepositoryInterface;

class TeacherService
{
    private TeacherRepositoryInterface $teacherRepository;
    private UserRepositoryInterface $userRepository;

    public function __construct(
        TeacherRepositoryInterface $teacherRepository,
        UserRepositoryInterface $userRepository
    ) {
        $this->teacherRepository = $teacherRepository;
        $this->userRepository = $userRepository;
    }

    public function createTeacher(string $name, string $email, string $password, string $hireDate): array
    {
        if ($this->userRepository->existsByEmail($email)) {
            throw new \Exception("Ese email ya tiene dueño, amigo. ¿Es tan difícil ser único?");
        }

        $user = new User($name, $email, $password, "teacher");
        $userId = $this->userRepository->create($user);

        $teacher = new Teacher($name, $email, $password, "teacher", $hireDate);
        $teacher->setId($userId);
        $this->teacherRepository->create($teacher);

        return [
            'message' => '¡Bam! Otro profe al sistema. A ver cuánto dura.',
        ];
    }

    public function deleteTeacher(int $userId): array
    {
        $teacher = $this->teacherRepository->findById($userId, true);
        if (!$teacher) {
            throw new \Exception("Profesor no encontrado.");
        }

        if ($this->teacherRepository->hasAssignments($teacher->getId())) {

            // 🔹 Ahora accedemos como array
            throw new \Exception("Lo sentimos, el profe tiene su 'residencia fija' en algún departamento.");
        }

        $this->teacherRepository->deleteUser($userId);

        return [
            'message' => 'Se fue. Que lo recuerden los que quieran... nosotros seguimos adelante.',
        ];
    }


    public function getAllTeachers(): array
    {
        return array_map(fn(Teacher $teacher) => $this->serialize($teacher), $this->teacherRepository->getAll());
    }


    private function serialize(Teacher $teacher): array
    {


        $user = $this->userRepository->findByTeacherId($teacher->getId()); // 🔹 Obtiene el objeto `User`

        return [
            'teacher_id' => $teacher->getId(),
            'user_id' => $user ? $user->getId() : null, // 🔹 Accedemos con `getId()`
            'name' => $teacher->getName(),
            'email' => $teacher->getEmail(),
            'hire_date' => $teacher->getHireDate(),
        ];
    }
}
