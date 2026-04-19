<?php

namespace EduSync\Models;

use EduSync\Core\Database;

class AcademicYear
{
    public static function getByUser(int $userId): array
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare('SELECT * FROM academic_years WHERE user_id = ? ORDER BY created_at DESC');
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public static function getActiveForUser(int $userId): ?array
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare('SELECT * FROM academic_years WHERE user_id = ? AND is_active = 1 LIMIT 1');
        $stmt->execute([$userId]);
        $row  = $stmt->fetch();
        if ($row) return $row;

        // Fall back to most recently created
        $stmt = $db->prepare('SELECT * FROM academic_years WHERE user_id = ? ORDER BY created_at DESC LIMIT 1');
        $stmt->execute([$userId]);
        $row  = $stmt->fetch();
        return $row ?: null;
    }

    public static function getByIdAndUser(int $id, int $userId): ?array
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare('SELECT * FROM academic_years WHERE id = ? AND user_id = ?');
        $stmt->execute([$id, $userId]);
        $row  = $stmt->fetch();
        return $row ?: null;
    }

    public static function create(int $userId, string $name): int
    {
        $db    = Database::getInstance();
        $stmt  = $db->prepare('SELECT COUNT(*) FROM academic_years WHERE user_id = ?');
        $stmt->execute([$userId]);
        $first = (int) $stmt->fetchColumn() === 0;

        $db->prepare('INSERT INTO academic_years (user_id, name, is_active) VALUES (?, ?, ?)')
           ->execute([$userId, $name, $first ? 1 : 0]);
        return (int) $db->lastInsertId();
    }

    public static function setActive(int $id, int $userId): void
    {
        $db = Database::getInstance();
        $db->prepare('UPDATE academic_years SET is_active = 0 WHERE user_id = ?')->execute([$userId]);
        $db->prepare('UPDATE academic_years SET is_active = 1 WHERE id = ? AND user_id = ?')->execute([$id, $userId]);
    }

    public static function rename(int $id, int $userId, string $name): void
    {
        Database::getInstance()
            ->prepare('UPDATE academic_years SET name = ? WHERE id = ? AND user_id = ?')
            ->execute([$name, $id, $userId]);
    }

    public static function delete(int $id, int $userId): void
    {
        Database::getInstance()
            ->prepare('DELETE FROM academic_years WHERE id = ? AND user_id = ?')
            ->execute([$id, $userId]);
    }

    public static function hasSubjects(int $id, int $userId): bool
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare('SELECT COUNT(*) FROM subjects WHERE academic_year_id = ? AND user_id = ?');
        $stmt->execute([$id, $userId]);
        return (int) $stmt->fetchColumn() > 0;
    }

    public static function getContentsSummary(int $id, int $userId): array
    {
        $db = Database::getInstance();

        $stmt = $db->prepare('SELECT COUNT(*) FROM subjects WHERE academic_year_id = ? AND user_id = ?');
        $stmt->execute([$id, $userId]);
        $subjects = (int) $stmt->fetchColumn();

        $stmt = $db->prepare(
            'SELECT COUNT(*) FROM themes t
             JOIN subjects s ON s.id = t.subject_id
             WHERE s.academic_year_id = ? AND s.user_id = ?'
        );
        $stmt->execute([$id, $userId]);
        $themes = (int) $stmt->fetchColumn();

        $stmt = $db->prepare(
            'SELECT COUNT(*) FROM chapters c
             JOIN themes t ON t.id = c.theme_id
             JOIN subjects s ON s.id = t.subject_id
             WHERE s.academic_year_id = ? AND s.user_id = ?'
        );
        $stmt->execute([$id, $userId]);
        $chapters = (int) $stmt->fetchColumn();

        $stmt = $db->prepare(
            'SELECT COUNT(*) FROM documents d
             JOIN chapters c ON c.id = d.chapter_id
             JOIN themes t ON t.id = c.theme_id
             JOIN subjects s ON s.id = t.subject_id
             WHERE s.academic_year_id = ? AND s.user_id = ?'
        );
        $stmt->execute([$id, $userId]);
        $documents = (int) $stmt->fetchColumn();

        $stmt = $db->prepare(
            'SELECT COUNT(*) FROM grades g
             JOIN subjects s ON s.id = g.subject_id
             WHERE s.academic_year_id = ? AND s.user_id = ?'
        );
        $stmt->execute([$id, $userId]);
        $grades = (int) $stmt->fetchColumn();

        return compact('subjects', 'themes', 'chapters', 'documents', 'grades');
    }

    public static function getDocumentsForExport(int $id, int $userId): array
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'SELECT s.name AS subject_name, t.name AS theme_name, c.name AS chapter_name,
                    d.title, d.original_name, d.content
             FROM subjects s
             JOIN themes t    ON t.subject_id = s.id
             JOIN chapters c  ON c.theme_id   = t.id
             LEFT JOIN documents d ON d.chapter_id = c.id
             WHERE s.academic_year_id = ? AND s.user_id = ?
             ORDER BY s.name, t.position, c.position, d.title'
        );
        $stmt->execute([$id, $userId]);
        return $stmt->fetchAll();
    }

    public static function getGradesForExport(int $id, int $userId): array
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'SELECT g.name, g.value, g.max_value, g.coefficient, g.graded_at, g.comment,
                    s.name AS subject_name
             FROM grades g
             JOIN subjects s ON s.id = g.subject_id
             WHERE s.academic_year_id = ? AND s.user_id = ?
             ORDER BY s.name, g.graded_at'
        );
        $stmt->execute([$id, $userId]);
        return $stmt->fetchAll();
    }
}
