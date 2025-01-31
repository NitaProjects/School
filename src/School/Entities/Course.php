<?php

namespace App\School\Entities;

class Course
{
    private int $id;
    private string $name;
    private string $description;
    private int $departmentId;

    public function __construct(string $name, string $description, int $departmentId)
    {
        $this->name = $name;
        $this->description = $description;
        $this->departmentId = $departmentId;
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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
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

    private ?string $departmentName = null;

    public function getDepartmentName(): ?string
    {
        return $this->departmentName;
    }

    public function setDepartmentName(?string $departmentName): self
    {
        $this->departmentName = $departmentName;
        return $this;
    }
}
