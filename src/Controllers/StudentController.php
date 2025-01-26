<?php

namespace App\Controllers;

use App\Infrastructure\HTTP\Response;
use App\School\Services\StudentService;

class StudentController
{
    private StudentService $service;

    public function __construct(StudentService $service)
    {
        $this->service = $service;
    }

    public function createForm(): Response
    {
        return Response::html('create-student');
    }

    public function deleteForm(): Response
    {
        return Response::html('delete-student', [
            'students' => $this->service->getAllStudents(),
        ]);
    }

    public function store($request): void
    {
        try {
            $result = $this->service->createStudent(
                $request->getParam('name'),
                $request->getParam('email'),
                $request->getParam('password'),
                $request->getParam('enrollment_date')
            );

            session_flash('message', $result['message']);
            session_flash('message_type', 'success');
        } catch (\Exception $e) {
            session_flash('message', $e->getMessage());
            session_flash('message_type', 'error');
        }

        redirect('/enroll-student');
    }

    public function delete($request, $params): void
    {
        try {
            $userId = $params['id'];

            $result = $this->service->deleteStudent((int) $userId);

            session_flash('message', $result['message']);
            session_flash('message_type', 'success');
        } catch (\Exception $e) {
            session_flash('message', $e->getMessage());
            session_flash('message_type', 'error');
        }

        redirect('/delete-student');
    }
}
