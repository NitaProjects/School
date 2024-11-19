<?php 

    namespace App\School\Services;
    use App\School\Entities\Student;
    use App\School\Entities\Course;
    use App\Infrastructure\Persistence\StudentRepository;
    use App\Infrastructure\Persistence\EnrollmentRepository;

    class EnrollmentService{
        private StudentRepository $studentRepository;
        private EnrollmentRepository $enrollmentRepository;

        function __construct(StudentRepository $studentRepo, EnrollmentRepository $enrollmentRepo)
        {
            $this->studentRepository=$studentRepo;
            $this->enrollmentRepository=$enrollmentRepo;
        }

        function enrollStudentInCourse(Student $student,Course $course){
            $student=$this->studentRepository->findByDni($student->getDni());
            if(!$student){
                throw new \Exception("Student not found");
            }
            $enrollment=new Enrollment(null,$student,$course);
            $this->enrollmentRepository->save($enrollment);
        }
    }