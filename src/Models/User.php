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

    public static function findById(int $id): ?array
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'SELECT id, email, first_name, last_name, created_at,
                    (profile_photo IS NOT NULL) AS has_photo
             FROM users WHERE id = ? LIMIT 1'
        );
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function updateInfo(int $id, string $firstName, string $lastName): void
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare('UPDATE users SET first_name = ?, last_name = ? WHERE id = ?');
        $stmt->execute([$firstName, $lastName, $id]);
    }

    public static function savePhoto(int $id, string $avatar, string $original, string $type): void
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'UPDATE users SET profile_photo = ?, profile_photo_original = ?, profile_photo_type = ? WHERE id = ?'
        );
        $stmt->execute([$avatar, $original, $type, $id]);
    }

    public static function saveCrop(int $id, string $avatar): void
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare('UPDATE users SET profile_photo = ? WHERE id = ?');
        $stmt->execute([$avatar, $id]);
    }

    public static function deletePhoto(int $id): void
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'UPDATE users SET profile_photo = NULL, profile_photo_original = NULL, profile_photo_type = NULL WHERE id = ?'
        );
        $stmt->execute([$id]);
    }

    public static function getPhoto(int $id): ?array
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare('SELECT profile_photo FROM users WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if (!$row || $row['profile_photo'] === null) {
            return null;
        }
        return ['data' => $row['profile_photo'], 'type' => 'image/jpeg'];
    }

    public static function getPhotoSource(int $id): ?array
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare('SELECT profile_photo_original, profile_photo_type FROM users WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if (!$row || $row['profile_photo_original'] === null) {
            return null;
        }
        return ['data' => $row['profile_photo_original'], 'type' => $row['profile_photo_type']];
    }

    public static function updateEmail(int $id, string $email): void
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare('UPDATE users SET email = ? WHERE id = ?');
        $stmt->execute([$email, $id]);
    }

    public static function updatePassword(int $id, string $password): void
    {
        $db   = Database::getInstance();
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $db->prepare('UPDATE users SET password = ? WHERE id = ?');
        $stmt->execute([$hash, $id]);
    }
}
