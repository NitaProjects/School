<?php

namespace App\Controllers;

use App\Infrastructure\HTTP\Response;
use App\School\Services\AssignTeacherToDepartmentService;

class TeacherController
{
    private AssignTeacherToDepartmentService $service;

    public function __construct(AssignTeacherToDepartmentService $service)
    {
        $this->service = $service;
    }

    public function showAssignForm(): Response
    {
        return Response::html('assign-teacher', [
            'teachers' => $this->service->getAllTeachers(),
            'departments' => $this->service->getAllDepartments(),
            'assignments' => $this->service->getAssignments(),
        ]);
    }

    public function assignToDepartment($request): void
    {
        try {
            $this->service->assignTeacherToDepartment(
                $request->getParam('teacher_id'),
                $request->getParam('department_id')
            );

            session_flash('message', 'Profesor asignado con éxito al departamento.');
            session_flash('message_type', 'success');
        } catch (\Exception $e) {
            session_flash('message', $e->getMessage());
            session_flash('message_type', 'error');
        }

        redirect('/assign-teacher');
    }

    public function deleteAssignment($request, $params): void
    {
        try {
            $this->service->deleteAssignment($params['id']);

            session_flash('message', 'Asignación eliminada con éxito.');
            session_flash('message_type', 'success');
        } catch (\Exception $e) {
            session_flash('message', $e->getMessage());
            session_flash('message_type', 'error');
        }

        redirect('/assign-teacher');
    }

    public function createForm(): Response
    {
        return Response::html('create-teacher');
    }

    public function store($request): void
    {
        try {
            $this->service->createTeacher(
                $request->getParam('name'),
                $request->getParam('email'),
                $request->getParam('password'),
                $request->getParam('hire_date')
            );

            session_flash('message', 'Profesor creado con éxito.');
            session_flash('message_type', 'success');
        } catch (\Exception $e) {
            session_flash('message', $e->getMessage());
            session_flash('message_type', 'error');
        }

        redirect('/assign-teacher');
    }
}
