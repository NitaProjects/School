<?php 

    namespace App\School\Student;

    interface StudentRepository{
        public function save(Student $student);
        public function findById($id);
        
    }