<?php

namespace App\School\Repositories;

use App\School\Entities\User;
use PDO;

class UserRepository implements UserRepositoryInterface
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function create(User $user): int
    {
        $stmt = $this->db->prepare("
            INSERT INTO users (name, email, password, user_type) 
            VALUES (:name, :email, :password, :user_type)
        ");
        $stmt->execute([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => password_hash($user->getPassword(), PASSWORD_BCRYPT),
            'user_type' => $user->getUserType()
        ]);

        return $this->db->lastInsertId();
    }

    public function existsByEmail(string $email): bool
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return (bool) $stmt->fetchColumn();
    }

    public function findById(int $id): ?User
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? $this->mapToEntity($data) : null;
    }

    private function mapToEntity(array $data): User
    {
        $user = new User(
            $data['name'],
            $data['email'],
            $data['password'],
            $data['user_type']
        );
        return $user->setId($data['id']);
    }

    public function findByTeacherId(int $teacherId): ?User
    {
        $stmt = $this->db->prepare("
        SELECT u.id, u.name, u.email, u.password, u.user_type 
        FROM users u
        JOIN teachers t ON u.id = t.user_id
        WHERE t.id = :teacher_id
    ");
        $stmt->execute(['teacher_id' => $teacherId]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        $user = new User($data['name'], $data['email'], $data['password'], $data['user_type']);
        $user->setId((int) $data['id']);

        return $user;
    }

    public function findByStudentId(int $studentId): ?User
    {
        $stmt = $this->db->prepare("
        SELECT u.id, u.name, u.email, u.password, u.user_type 
        FROM users u
        JOIN students s ON u.id = s.user_id
        WHERE s.id = :student_id
    ");
        $stmt->execute(['student_id' => $studentId]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        $user = new User($data['name'], $data['email'], $data['password'], $data['user_type']);
        $user->setId((int) $data['id']);

        return $user;
    }
}
