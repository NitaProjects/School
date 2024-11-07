<?php

namespace App\School\Repositories;
use App\School\Entities\Course;

    interface CourseRepository{
        public function save(Course $course);
        public function findById($id);
        
    }
    