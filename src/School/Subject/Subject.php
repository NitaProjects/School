<?php

    namespace App\School\Subject;

    use App\School\Course\Course;

    class Subject{
        protected string $name;
        protected Course $course;

        function __construct(string $name){
            $this->name=$name;
           
        }

    }