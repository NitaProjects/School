<?php

namespace App\School\Entities;

class Enrollment
{
    private int $id;
    private Student $student;
    private Course $course;
    private string $enrollmentDate;

    public function __construct(Student $student, Course $course, string $enrollmentDate)
    {
        $this->student = $student;
        $this->course = $course;
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

    public function getStudent(): Student
    {
        return $this->student;
    }

    public function setStudent(Student $student): self
    {
        $this->student = $student;
        return $this;
    }

    public function getCourse(): Course
    {
        return $this->course;
    }

    public function setCourse(Course $course): self
    {
        $this->course = $course;
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
