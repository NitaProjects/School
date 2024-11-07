<?php

    namespace App\School\Entities;

    use App\School\Entities\Course;

    class Subject{
        protected string $name;
        protected Course $course;

        function __construct(string $name){
            $this->name=$name;
           
        }

    }