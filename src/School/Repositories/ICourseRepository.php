<?php

namespace App\School\Repositories;
use App\School\Entities\Course;

    interface ICourseRepository{
        public function save(Course $course);
        public function findById($id);
        
    }
    