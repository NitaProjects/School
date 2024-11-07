<?php 

    namespace App\School\Repositories;

    use App\School\Entities\Student;
    
    interface StudentRepository{
        public function save(Student $student);
        public function findById($id);
        
    }