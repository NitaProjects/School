<?php

namespace App\Controllers;

use App\Infrastructure\HTTP\Response;
use App\School\Services\AssignTeacherToDepartmentService;

class AssignTeacherToDepartmentController
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

            session_flash('message', 'Asignado al departamento. Que no olvide traer galletas al equipo.');
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

            session_flash('message', 'El profesor ha sido expulsado del departamento. ¿Se lo merecía? Probablemente.');
            session_flash('message_type', 'success');
        } catch (\Exception $e) {
            session_flash('message', $e->getMessage());
            session_flash('message_type', 'error');
        }

        redirect('/assign-teacher');
    }
}
