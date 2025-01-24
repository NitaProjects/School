<?php

namespace App\School\Entities;

class Student extends User
{
    private string $enrollmentDate;

    public function __construct(
        string $name,
        string $email,
        string $password,
        string $userType,
        string $enrollmentDate
    ) {
        parent::__construct($name, $email, $password, $userType);
        $this->enrollmentDate = $enrollmentDate;
    }

    public function getEnrollmentDate(): string
    {
        return $this->enrollmentDate;
    }

    public function setEnrollmentDate(string $enrollmentDate): self
    {
        $this->enrollmentDate = $enrollmentDate;
        return $this;
    }
}
