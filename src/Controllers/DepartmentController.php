<?php

namespace App\Controllers;

use App\Infrastructure\HTTP\Response;
use App\School\Services\DepartmentService;
use App\School\Entities\Department;

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

    //PRUEBAS
    public function manageForm(): Response
    {
        return Response::html('manage-department', [
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

        redirect('/manage-department');
    }

    public function update($request, $params): void
    {
        try {
            $departmentId = (int) $params['id'];

            // Obtener datos como array y convertirlo a un objeto Department
            $departmentData = $this->service->getDepartmentById($departmentId);
            $department = new Department($departmentData['name'], $departmentData['description']);
            $department->setId($departmentData['id']);

            // Actualizar con los nuevos valores
            $department->setName($request->getParam('name'))
                ->setDescription($request->getParam('description'));

            $result = $this->service->updateDepartment(
                $department->getId(),
                $department->getName(),
                $department->getDescription()
            );

            session_flash('message', $result['message']);
            session_flash('message_type', 'success');
        } catch (\Exception $e) {
            session_flash('message', $e->getMessage());
            session_flash('message_type', 'error');
        }

        redirect('/manage-department');
    }


    public function delete($_request, $params): void
    {
        try {
            $departmentId = (int) $params['id'];

            $result = $this->service->deleteDepartment($departmentId);

            session_flash('message', $result['message']);
            session_flash('message_type', 'success');
        } catch (\Exception $e) {
            session_flash('message', $e->getMessage());
            session_flash('message_type', 'error');
        }

        redirect('/manage-department');
    }
}
