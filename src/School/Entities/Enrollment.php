<?php
    namespace App\School\Entities;



    class Enrollment{
        private int $id;
        private Student $student;
        private Course $course;
        private ?Subject $subject;
        private \DateTime $enrollmentDate;
        
        
        public function getStudent()
        {
                return $this->student;
        }

        public function getId()
        {
                return $this->id;
        }
    }