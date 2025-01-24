<?php

// Definir constantes de rutas
define('VIEWS', __DIR__ . '/src/views');
require __DIR__ . '/vendor/autoload.php';

// Cargar variables del entorno
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Crear el contenedor de servicios
$services = new \App\School\Services\Services();

// Base de datos (usando la clase DatabaseConnection)
$services->addServices('db', function () {
    return \App\Infrastructure\Database\DatabaseConnection::getConnection();
});

// Repositorios
$services->addServices('userRepository', function ($services) {
    return new \App\School\Repositories\UserRepository($services->getService('db'));
});
$services->addServices('teacherRepository', function ($services) {
    return new \App\School\Repositories\TeacherRepository($services->getService('db'));
});
$services->addServices('departmentRepository', function ($services) {
    return new \App\School\Repositories\DepartmentRepository($services->getService('db'));
});
$services->addServices('studentRepository', function ($services) {
    return new \App\School\Repositories\StudentRepository($services->getService('db'));
});
$services->addServices('courseRepository', function ($services) {
    return new \App\School\Repositories\CourseRepository($services->getService('db'));
});
$services->addServices('enrollmentRepository', function ($services) {
    return new \App\School\Repositories\EnrollmentRepository($services->getService('db'));
});
$services->addServices('assignmentRepository', function ($services) {
    return new \App\School\Repositories\AssignmentRepository($services->getService('db'));
});

// Servicios
$services->addServices('assignTeacherService', function ($services) {
    return new \App\School\Services\AssignTeacherToDepartmentService(
        $services->getService('teacherRepository'),
        $services->getService('departmentRepository'),
        $services->getService('assignmentRepository'),
        $services->getService('userRepository')
    );
});
$services->addServices('enrollStudentService', function ($services) {
    return new \App\School\Services\EnrollStudentInCourseService(
        $services->getService('studentRepository'),
        $services->getService('courseRepository'),
        $services->getService('enrollmentRepository'),
        $services->getService('userRepository')
    );
});

// Controladores
$services->addServices('homeController', function () {
    return new \App\Controllers\HomeController();
});
$services->addServices('teacherController', function ($services) {
    return new \App\Controllers\TeacherController(
        $services->getService('assignTeacherService'),
        $services->getService('teacherRepository'),
        $services->getService('departmentRepository'),
        $services->getService('userRepository')
    );
});
$services->addServices('studentController', function ($services) {
    return new \App\Controllers\StudentController(
        $services->getService('enrollStudentService'),
        $services->getService('studentRepository'),
        $services->getService('courseRepository'),
        $services->getService('userRepository')
    );
});

// Configuración de rutas
$router = new \App\Infrastructure\Routing\Router();
$router
    ->addRoute('GET', '/', [$services->getService('homeController'), 'index'])
    ->addRoute('GET', '/assign-teacher', [$services->getService('teacherController'), 'showAssignForm'])
    ->addRoute('POST', '/assign-teacher', [$services->getService('teacherController'), 'assignToDepartment'])
    ->addRoute('POST', '/assignments/{id}/delete', [$services->getService('teacherController'), 'deleteAssignment'])
    ->addRoute('GET', '/create-teacher', [$services->getService('teacherController'), 'createForm'])
    ->addRoute('POST', '/store-teacher', [$services->getService('teacherController'), 'store'])


    ->addRoute('GET', '/enroll-student', [$services->getService('studentController'), 'showEnrollForm'])
    ->addRoute('POST', '/enroll-student', [$services->getService('studentController'), 'enrollInCourse'])
    ->addRoute('POST', '/enrollments/{id}/delete', [$services->getService('studentController'), 'deleteEnrollment'])
    ->addRoute('GET', '/create-student', [$services->getService('studentController'), 'createForm'])
    ->addRoute('POST', '/store-student', [$services->getService('studentController'), 'store']);
