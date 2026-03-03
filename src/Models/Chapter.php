<?php

namespace EduSync\Models;

use EduSync\Core\Database;

class Chapter
{
    public static function getAllByTheme(int $themeId): array
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'SELECT * FROM chapters WHERE theme_id = ? ORDER BY position ASC, name ASC'
        );
        $stmt->execute([$themeId]);
        return $stmt->fetchAll();
    }

    /**
     * Returns the chapter with its theme and subject, checking ownership via user_id.
     */
    public static function getByIdForUser(int $id, int $userId): array|false
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'SELECT c.*, t.name AS theme_name, t.id AS theme_id,
                    s.name AS subject_name, s.id AS subject_id
             FROM chapters c
             JOIN themes t   ON c.theme_id   = t.id
             JOIN subjects s ON t.subject_id  = s.id
             WHERE c.id = ? AND s.user_id = ?'
        );
        $stmt->execute([$id, $userId]);
        return $stmt->fetch();
    }

    public static function create(int $themeId, string $name, string $color): int
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'INSERT INTO chapters (theme_id, name, color) VALUES (?, ?, ?)'
        );
        $stmt->execute([$themeId, $name, $color]);
        return (int) $db->lastInsertId();
    }

    public static function update(int $id, string $name, string $color): void
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare('UPDATE chapters SET name = ?, color = ? WHERE id = ?');
        $stmt->execute([$name, $color, $id]);
    }

    public static function delete(int $id): void
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare('DELETE FROM chapters WHERE id = ?');
        $stmt->execute([$id]);
    }
}
