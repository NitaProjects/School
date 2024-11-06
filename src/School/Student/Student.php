<?php

    namespace App\School\Student;

    use App\School\User;
    use App\School\Student\StudentRepository;
    use App\School\Trait\Timestampable;

    class Student extends User {
        use Timestampable;

        protected $enrollments=[];

        public function showSchool(){
            echo parent::MYSCHOOL;
        }
       
        function __construct($email,$name){
           
            $this->updateTimestamps();
        }

    }