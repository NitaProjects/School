<?php

    namespace App\School\Entities;

    use App\School\Trait\Timestampable;
    use App\School\Entities\User;
    use App\School\Entities\Department;


    class Teacher extends User{
        use Timestampable;

        protected $department;

        function __construct($email,$name){
            parent::__construct($email,$name);
            $this->updateTimestamps();
        }

        public function addToDepartment(Department $dept){
            $this->department=$dept;
        }
    }