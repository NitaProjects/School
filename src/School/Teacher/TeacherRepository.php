<?php 

    namespace App\School\Teacher;

    use App\School\Teacher\Teacher;

    interface TeacherRepository{
        public function save(Teacher $teacher);
        public function findById($id);
        
    }