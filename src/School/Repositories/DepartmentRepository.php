<?php

namespace App\School\Repositories;
use App\School\Entities\Department;

    interface DepartmentRepository{
        public function save(Department $department);
        public function findById($id);
        
    }