<?php

    namespace App\School\Entities;

    use App\School\Entities\User;
   
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