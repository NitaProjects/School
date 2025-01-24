<?php

namespace Tests\Integration;

use PHPUnit\Framework\TestCase;
use App\Infrastructure\Database\DatabaseConnection;
use App\School\Services\AssignTeacherToDepartmentService;
use App\School\Repositories\TeacherRepository;
use App\School\Repositories\DepartmentRepository;
use App\School\Repositories\AssignmentRepository;
use App\School\Repositories\UserRepository;

class AssignTeacherToDepartmentIntegrationTest extends TestCase
{
    private $db;
    private $service;
    private $teacherRepository;
    private $departmentRepository;
    private $assignmentRepository;
    private $userRepository;

    protected function setUp(): void
    {
        // Conectar a la base de datos
        $this->db = DatabaseConnection::getConnection();

        // Limpiar las tablas antes de cada prueba
        $this->db->exec('DELETE FROM assignments');
        $this->db->exec('DELETE FROM teachers');
        $this->db->exec('DELETE FROM departments');
        $this->db->exec('DELETE FROM users');

        // Crear repositorios y servicio
        $this->teacherRepository = new TeacherRepository($this->db);
        $this->departmentRepository = new DepartmentRepository($this->db);
        $this->assignmentRepository = new AssignmentRepository($this->db);
        $this->userRepository = new UserRepository($this->db);

        $this->service = new AssignTeacherToDepartmentService(
            $this->teacherRepository,
            $this->departmentRepository,
            $this->assignmentRepository,
            $this->userRepository
        );

        // Insertar datos iniciales
        $this->db->exec("INSERT INTO departments (id, name, description) VALUES (1, 'Math', 'Matematicas'), (2, 'Science', 'Matematicas')");
        $this->db->exec("INSERT INTO users (id, name, email, password, user_type) VALUES (1, 'John Doe', 'john@example.com', 'password', 'teacher')");
        $this->db->exec("INSERT INTO teachers (id, user_id, hire_date) VALUES (1, 1, '2025-01-01')");
    }

    public function testAssignTeacherSuccessfully(): void
    {
        $this->service->execute(1, 1);

        $assignment = $this->db->query("SELECT * FROM assignments WHERE teacher_id = 1 AND department_id = 1")->fetch();
        $this->assertNotEmpty($assignment);
        $this->assertEquals(1, $assignment['teacher_id']);
        $this->assertEquals(1, $assignment['department_id']);
    }

    public function testAssignTeacherFailsWhenAlreadyAssigned(): void
    {
        $this->db->exec("INSERT INTO assignments (teacher_id, department_id) VALUES (1, 1)");

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Este profesor ya está asignado a este departamento.");

        $this->service->execute(1, 1);
    }

    public function testAssignTeacherFailsWhenTeacherNotFound(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Profesor no encontrado");

        $this->service->execute(999, 1); // teacher_id 999 no existe
    }

    public function testAssignTeacherFailsWhenDepartmentNotFound(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Departamento no encontrado");

        $this->service->execute(1, 999); // department_id 999 no existe
    }

    public function testDeleteAssignmentSuccessfully(): void
    {
        $this->db->exec("INSERT INTO assignments (id, teacher_id, department_id) VALUES (1, 1, 1)");

        $this->service->deleteAssignment(1);

        $assignment = $this->db->query("SELECT * FROM assignments WHERE id = 1")->fetch();
        $this->assertEmpty($assignment);
    }

    public function testDeleteAssignmentFailsWhenNotFound(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Asignación no encontrada.");

        $this->service->deleteAssignment(999); // ID inexistente
    }

    public function testAssignTeacherWithInvalidTeacherId(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Profesor no encontrado");

        $this->service->execute(0, 1); // teacher_id inválido
    }

    public function testAssignTeacherWithInvalidDepartmentId(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Departamento no encontrado");

        $this->service->execute(1, 0); // department_id inválido
    }

    public function testGetAssignmentsSuccessfully(): void
    {
        $this->db->exec("INSERT INTO assignments (teacher_id, department_id) VALUES (1, 1), (1, 2)");

        $assignments = $this->service->getAssignments();

        $this->assertCount(2, $assignments);
        $this->assertEquals(1, $assignments[0]['teacher_id']);
        $this->assertEquals(1, $assignments[0]['department_id']);
        $this->assertEquals(2, $assignments[1]['department_id']);
    }
}
