<?php

namespace App\School\Entities;

class Teacher extends User
{
    private string $hireDate;

    public function __construct(
        string $name,
        string $email,
        string $password,
        string $userType,
        string $hireDate
    ) {
        parent::__construct($name, $email, $password, $userType);
        $this->hireDate = $hireDate;
    }

    public function getHireDate(): string
    {
        return $this->hireDate;
    }

    public function setHireDate(string $hireDate): self
    {
        $this->hireDate = $hireDate;
        return $this;
    }
}
