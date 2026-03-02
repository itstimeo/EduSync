<?php

namespace EduSync\Models;

use EduSync\Core\Database;
use PDO;

class User
{
    public static function findByEmail(string $email): ?array
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function create(string $email, string $password, string $firstName, string $lastName): int
    {
        $db   = Database::getInstance();
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $db->prepare(
            'INSERT INTO users (email, password, first_name, last_name) VALUES (?, ?, ?, ?)'
        );
        $stmt->execute([$email, $hash, $firstName, $lastName]);
        return (int) $db->lastInsertId();
    }
}
