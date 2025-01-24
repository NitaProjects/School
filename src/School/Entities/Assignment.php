<?php

namespace App\School\Entities;

class Assignment
{
    private int $id;
    private int $teacherId;
    private int $departmentId;
    private string $assignedDate;

    public function __construct(int $teacherId, int $departmentId, string $assignedDate)
    {
        $this->teacherId = $teacherId;
        $this->departmentId = $departmentId;
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

    public function getTeacherId(): int
    {
        return $this->teacherId;
    }

    public function setTeacherId(int $teacherId): self
    {
        $this->teacherId = $teacherId;
        return $this;
    }

    public function getDepartmentId(): int
    {
        return $this->departmentId;
    }

    public function setDepartmentId(int $departmentId): self
    {
        $this->departmentId = $departmentId;
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
