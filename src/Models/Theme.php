<?php

namespace EduSync\Models;

use EduSync\Core\Database;

class Theme
{
    public static function getAllBySubject(int $subjectId): array
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'SELECT * FROM themes WHERE subject_id = ? ORDER BY position ASC, name ASC'
        );
        $stmt->execute([$subjectId]);
        return $stmt->fetchAll();
    }

    public static function getByIdAndSubject(int $id, int $subjectId): array|false
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'SELECT * FROM themes WHERE id = ? AND subject_id = ?'
        );
        $stmt->execute([$id, $subjectId]);
        return $stmt->fetch();
    }

    /**
     * Returns the theme with its subject, checking the subject belongs to the user.
     */
    public static function getByIdForUser(int $id, int $userId): array|false
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'SELECT t.*, s.name AS subject_name, s.id AS subject_id
             FROM themes t
             JOIN subjects s ON t.subject_id = s.id
             WHERE t.id = ? AND s.user_id = ?'
        );
        $stmt->execute([$id, $userId]);
        return $stmt->fetch();
    }

    public static function create(int $subjectId, string $name, string $color): int
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'INSERT INTO themes (subject_id, name, color) VALUES (?, ?, ?)'
        );
        $stmt->execute([$subjectId, $name, $color]);
        return (int) $db->lastInsertId();
    }

    public static function update(int $id, string $name, string $color): void
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'UPDATE themes SET name = ?, color = ? WHERE id = ?'
        );
        $stmt->execute([$name, $color, $id]);
    }

    public static function delete(int $id): void
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare('DELETE FROM themes WHERE id = ?');
        $stmt->execute([$id]);
    }
}
