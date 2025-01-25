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

    public function store($request): void
    {
        try {
            $this->service->createTeacher(
                $request->getParam('name'),
                $request->getParam('email'),
                $request->getParam('password'),
                $request->getParam('hire_date')
            );

            session_flash('message', '¡Bam! Otro profe al sistema. A ver cuánto dura.');
            session_flash('message_type', 'success');
        } catch (\Exception $e) {
            session_flash('message', $e->getMessage());
            session_flash('message_type', 'error');
        }

        redirect('/assign-teacher');
    }
}
