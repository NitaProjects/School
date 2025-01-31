<?php

namespace App\Controllers;

use App\Infrastructure\HTTP\Response;
use App\School\Services\TeacherService;

class TeacherController
{
    private TeacherService $service;

    public function __construct(TeacherService $service)
    {
        $this->service = $service;
    }

    public function createForm(): Response
    {
        return Response::html('create-teacher');
    }

    public function deleteForm(): Response
    {
        return Response::html('delete-teacher', [
            'teachers' => $this->service->getAllTeachers(), 
        ]);
    }

    public function store($request): void
    {
        try {
            $result = $this->service->createTeacher(
                $request->getParam('name'),
                $request->getParam('email'),
                $request->getParam('password'),
                $request->getParam('hire_date')
            );

            session_flash('message', $result['message']);
            session_flash('message_type', 'success');
        } catch (\Exception $e) {
            session_flash('message', $e->getMessage());
            session_flash('message_type', 'error');
        }

        redirect('/assign-teacher');
    }

    public function delete($_request, $params): void
    {
        try {
            $userId = (int) $params['id']; 

            $result = $this->service->deleteTeacher($userId);

            session_flash('message', $result['message']);
            session_flash('message_type', 'success');
        } catch (\Exception $e) {
            session_flash('message', $e->getMessage());
            session_flash('message_type', 'error');
        }

        redirect('/delete-teacher');
    }
}
