<?php

namespace App\Controllers;

use App\Infrastructure\HTTP\Response;
use App\School\Services\EnrollStudentInCourseService;

class EnrollStudentInCourseController
{
    private EnrollStudentInCourseService $service;

    public function __construct(EnrollStudentInCourseService $service)
    {
        $this->service = $service;
    }

    public function showEnrollForm(): Response
    {
        return Response::html('enroll-student', [
            'students' => $this->service->getAllStudents(),
            'courses' => $this->service->getAllCourses(),
            'enrollments' => $this->service->getEnrollments(),
        ]);
    }

    public function enrollInCourse($request): void
    {
        try {
            $result = $this->service->enrollStudentInCourse(
                (int) $request->getParam('student_id'),
                (int) $request->getParam('course_id')
            );

            session_flash('message', $result['message']);
            session_flash('message_type', 'success');
        } catch (\Exception $e) {
            session_flash('message', $e->getMessage());
            session_flash('message_type', 'error');
        }

        redirect('/enroll-student');
    }

    public function deleteEnrollment($_request, $params): void
    {
        try {
            $result = $this->service->deleteEnrollment((int) $params['id']);

            session_flash('message', $result['message']);
            session_flash('message_type', 'success');
        } catch (\Exception $e) {
            session_flash('message', $e->getMessage());
            session_flash('message_type', 'error');
        }

        redirect('/enroll-student');
    }
}
