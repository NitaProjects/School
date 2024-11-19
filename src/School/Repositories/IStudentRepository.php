<?php 

    namespace App\School\Repositories;

    use App\School\Entities\Student;
    
    interface IStudentRepository{
        public function save(Student $student);
        public function findById($id);
        
    }