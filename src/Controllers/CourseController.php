<?php

namespace App\Controllers;

use App\Infrastructure\HTTP\Response;
use App\School\Services\CourseService;
use App\School\Services\DepartmentService;

class CourseController
{
    private CourseService $courseService;
    private DepartmentService $departmentService;

    public function __construct(CourseService $courseService, DepartmentService $departmentService)
    {
        $this->courseService = $courseService;
        $this->departmentService = $departmentService;
    }

    public function createForm(): Response
    {
        return Response::html('create-course', [
            'departments' => $this->departmentService->getAllDepartments(),
        ]);
    }

    public function deleteForm(): Response
    {
        return Response::html('delete-course', [
            'courses' => $this->courseService->getAllCourses(),
        ]);
    }

    public function store($request): void
    {
        try {
            $result = $this->courseService->createCourse(
                $request->getParam('name'),
                $request->getParam('description'),
                $request->getParam('department_id')
            );

            session_flash('message', $result['message']);
            session_flash('message_type', 'success');
        } catch (\Exception $e) {
            session_flash('message', $e->getMessage());
            session_flash('message_type', 'error');
        }

        redirect('/create-course');
    }

    public function delete($request, $params): void
    {
        try {
            $courseId = $params['id'];

            $result = $this->courseService->deleteCourse((int) $courseId);

            session_flash('message', $result['message']);
            session_flash('message_type', 'success');
        } catch (\Exception $e) {
            session_flash('message', $e->getMessage());
            session_flash('message_type', 'error');
        }

        redirect('/delete-course');
    }
}
