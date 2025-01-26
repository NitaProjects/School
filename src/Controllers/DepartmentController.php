<?php

namespace App\Controllers;

use App\Infrastructure\HTTP\Response;
use App\School\Services\DepartmentService;

class DepartmentController
{
    private DepartmentService $service;

    public function __construct(DepartmentService $service)
    {
        $this->service = $service;
    }

    public function createForm(): Response
    {
        return Response::html('create-department');
    }

    public function deleteForm(): Response
    {
        return Response::html('delete-department', [
            'departments' => $this->service->getAllDepartments(),
        ]);
    }

    public function updateForm(): Response
    {
        return Response::html('update-department', [
            'departments' => $this->service->getAllDepartments(),
        ]);
    }


    public function store($request): void
    {
        try {
            $result = $this->service->createDepartment(
                $request->getParam('name'),
                $request->getParam('description')
            );

            session_flash('message', $result['message']);
            session_flash('message_type', 'success');
        } catch (\Exception $e) {
            session_flash('message', $e->getMessage());
            session_flash('message_type', 'error');
        }

        redirect('/create-department');
    }

    public function update($request, $params): void
    {
        try {
            $departmentId = $params['id'];

            $result = $this->service->updateDepartment(
                (int)$departmentId,
                $request->getParam('name'),
                $request->getParam('description')
            );

            session_flash('message', $result['message']);
            session_flash('message_type', 'success');
        } catch (\Exception $e) {
            session_flash('message', $e->getMessage());
            session_flash('message_type', 'error');
        }

        redirect('/update-department');
    }

    public function delete($_request, $params): void
    {
        try {
            $departmentId = $params['id'];

            $result = $this->service->deleteDepartment((int) $departmentId);

            session_flash('message', $result['message']);
            session_flash('message_type', 'success');
        } catch (\Exception $e) {
            session_flash('message', $e->getMessage());
            session_flash('message_type', 'error');
        }

        redirect('/delete-department');
    }
}
