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
            $this->service->enrollStudentInCourse(
                $request->getParam('student_id'),
                $request->getParam('course_id')
            );

            session_flash('message', '¡Inscripción completa! Ahora, que estudie.');
            session_flash('message_type', 'success');
        } catch (\Exception $e) {
            session_flash('message', $e->getMessage());
            session_flash('message_type', 'error');
        }

        redirect('/enroll-student');
    }

    public function deleteEnrollment($request, $params): void
    {
        try {
            $this->service->deleteEnrollment($params['id']);

            session_flash('message', 'Alumno eliminado del curso. Quizás lo piense mejor la próxima vez.');
            session_flash('message_type', 'success');
        } catch (\Exception $e) {
            session_flash('message', $e->getMessage());
            session_flash('message_type', 'error');
        }

        redirect('/enroll-student');
    }
}
