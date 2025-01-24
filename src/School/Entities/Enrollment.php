<?php

namespace App\School\Entities;

class Enrollment
{
    private int $id;
    private int $studentId;
    private int $courseId;
    private string $enrollmentDate;

    public function __construct(int $studentId, int $courseId, string $enrollmentDate)
    {
        $this->studentId = $studentId;
        $this->courseId = $courseId;
        $this->enrollmentDate = $enrollmentDate;
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

    public function getStudentId(): int
    {
        return $this->studentId;
    }

    public function setStudentId(int $studentId): self
    {
        $this->studentId = $studentId;
        return $this;
    }

    public function getCourseId(): int
    {
        return $this->courseId;
    }

    public function setCourseId(int $courseId): self
    {
        $this->courseId = $courseId;
        return $this;
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
