<?php

namespace App\School\Repositories;

use App\School\Entities\User;

interface IUserRepository{
    public function save(User $user);
    public function findByDni(string $dni);
    
}