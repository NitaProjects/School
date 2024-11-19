<?php

    namespace App\Infrastructure\Persistence;


    use App\School\Entities\Enrollment;
    use App\School\Repositories\IEnrollmentRepository;

    class EnrollmentRepository implements IEnrollmentRepository{
        private \PDO $db;
        function __construct(\PDO $db){
            $this->db=$db;
        }
        function save(Enrollment $enrollment){
            $stmt=$this->db->prepare("INSERT INTO enrollments() VALUES()");
            $stmt->execute([]);
            return $stmt->fetchObject(Enrollment::class);
        }
        
        function findByDni(string $dni){

        }
    }