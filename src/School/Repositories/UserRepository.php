<?php

namespace App\School\Repositories;

use PDO;

class UserRepository {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function create(string $name, string $email, string $password, string $userType): int
{
    $stmt = $this->db->prepare("
        INSERT INTO users (name, email, password, user_type) 
        VALUES (:name, :email, :password, :user_type)
    ");
    $stmt->execute([
        'name' => $name,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_BCRYPT),
        'user_type' => $userType
    ]);
    return $this->db->lastInsertId();
}

public function existsByEmail(string $email): bool
{
    $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    return (bool) $stmt->fetchColumn();
}
    
}
