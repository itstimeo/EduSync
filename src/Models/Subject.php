<?php

namespace EduSync\Models;

use EduSync\Core\Database;

class Subject
{
    public static function getAllByUser(int $userId): array
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'SELECT * FROM subjects WHERE user_id = ? ORDER BY name ASC'
        );
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public static function getAllByUserAndYear(int $userId, int $yearId): array
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'SELECT * FROM subjects WHERE user_id = ? AND academic_year_id = ? ORDER BY name ASC'
        );
        $stmt->execute([$userId, $yearId]);
        return $stmt->fetchAll();
    }

    public static function getByIdAndUser(int $id, int $userId): array|false
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'SELECT * FROM subjects WHERE id = ? AND user_id = ?'
        );
        $stmt->execute([$id, $userId]);
        return $stmt->fetch();
    }

    public static function create(int $userId, string $name, string $color, int $yearId): int
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'INSERT INTO subjects (user_id, name, color, academic_year_id) VALUES (?, ?, ?, ?)'
        );
        $stmt->execute([$userId, $name, $color, $yearId]);
        return (int) $db->lastInsertId();
    }

    public static function update(int $id, int $userId, string $name, string $color): void
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'UPDATE subjects SET name = ?, color = ? WHERE id = ? AND user_id = ?'
        );
        $stmt->execute([$name, $color, $id, $userId]);
    }

    public static function delete(int $id, int $userId): void
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'DELETE FROM subjects WHERE id = ? AND user_id = ?'
        );
        $stmt->execute([$id, $userId]);
    }
}
