<?php
    namespace App\Infrastructure\Persistence;

use App\Infrastructure\Database\DatabaseConnection;
use App\School\Repositories\IUserRepository;
    use App\School\Entities\User;

    class UserRepository implements IUserRepository{
        private \PDO $db;

        function __construct(\PDO $db){

            $this->db=$db;
        }

        function save(User $user){
            $stmt=$this->db->prepare("INSERT INTO users(username,email) VALUES(:username,:email)");
            $stmt->execute([
                'username'=>$user->getUsername(),
                'email'=>$user->getEmail()
            ]);

        }
        function findByDni(string $dni):?User{
            $stmt=$this->db->prepare("SELECT * FROM users WHERE dni=:dni");
            $stmt->execute(['dni'=>$dni]);
            return $stmt->fetchObject(User::class);
        }
    }