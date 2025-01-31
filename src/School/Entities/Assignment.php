<?php

namespace App\School\Entities;

class Assignment
{
    private int $id;
    private Teacher $teacher;
    private Department $department;
    private string $assignedDate;

    public function __construct(Teacher $teacher, Department $department, string $assignedDate)
    {
        $this->teacher = $teacher;
        $this->department = $department;
        $this->assignedDate = $assignedDate;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getTeacher(): Teacher
    {
        return $this->teacher;
    }

    public function setTeacher(Teacher $teacher): self
    {
        $this->teacher = $teacher;
        return $this;
    }

    public function getDepartment(): Department
    {
        return $this->department;
    }

    public function setDepartment(Department $department): self
    {
        $this->department = $department;
        return $this;
    }

    public function getAssignedDate(): string
    {
        return $this->assignedDate;
    }

    public function setAssignedDate(string $assignedDate): self
    {
        $this->assignedDate = $assignedDate;
        return $this;
    }
}
