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

    public function store($request): void
    {
        try {
            $this->service->createStudent(
                $request->getParam('name'),
                $request->getParam('email'),
                $request->getParam('password'),
                $request->getParam('enrollment_date')
            );

            session_flash('message', '¡Nuevo recluta listo! Espero que tenga buen aguante.');
            session_flash('message_type', 'success');
        } catch (\Exception $e) {
            session_flash('message', $e->getMessage());
            session_flash('message_type', 'error');
        }

        redirect('/enroll-student');
    }
}
