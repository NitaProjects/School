<?php

namespace App\School\Repositories;
use App\School\Entities\Subject;

    interface SubjectRepository{
        public function save(Subject $subject);
        public function findById($id);
        
    }