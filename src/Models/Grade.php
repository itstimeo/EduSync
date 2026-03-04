<?php

namespace EduSync\Models;

use EduSync\Core\Database;

class Grade
{
    public static function getRecentByUser(int $userId, int $limit = 5): array
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'SELECT g.*, s.name AS subject_name, s.color AS subject_color
             FROM grades g
             JOIN subjects s ON g.subject_id = s.id
             WHERE g.user_id = ?
             ORDER BY g.created_at DESC
             LIMIT ' . (int) $limit
        );
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public static function getWeightedAverage(int $userId): ?float
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'SELECT AVG(subject_avg) AS average FROM (
                SELECT SUM(g.value / g.max_value * 20 * g.coefficient) / SUM(g.coefficient) AS subject_avg
                FROM grades g
                WHERE g.user_id = ?
                GROUP BY g.subject_id
            ) AS sub'
        );
        $stmt->execute([$userId]);
        $row = $stmt->fetch();
        return isset($row['average']) && $row['average'] !== null ? (float) $row['average'] : null;
    }

    public static function getAllByUser(int $userId): array
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'SELECT g.*, s.name AS subject_name, s.color AS subject_color
             FROM grades g
             JOIN subjects s ON g.subject_id = s.id
             WHERE g.user_id = ?
             ORDER BY g.graded_at DESC, g.created_at DESC'
        );
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public static function getByIdAndUser(int $id, int $userId): array|false
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'SELECT g.*, s.name AS subject_name, s.color AS subject_color
             FROM grades g
             JOIN subjects s ON g.subject_id = s.id
             WHERE g.id = ? AND g.user_id = ?'
        );
        $stmt->execute([$id, $userId]);
        return $stmt->fetch();
    }

    public static function create(
        int $userId, int $subjectId, string $name,
        float $value, float $maxValue, float $coefficient,
        ?string $gradedAt, ?string $comment
    ): int {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'INSERT INTO grades (user_id, subject_id, name, value, max_value, coefficient, graded_at, comment)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([$userId, $subjectId, $name, $value, $maxValue, $coefficient, $gradedAt, $comment]);
        return (int) $db->lastInsertId();
    }

    public static function update(
        int $id, int $userId, int $subjectId, string $name,
        float $value, float $maxValue, float $coefficient,
        ?string $gradedAt, ?string $comment
    ): void {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'UPDATE grades
             SET subject_id = ?, name = ?, value = ?, max_value = ?, coefficient = ?, graded_at = ?, comment = ?
             WHERE id = ? AND user_id = ?'
        );
        $stmt->execute([$subjectId, $name, $value, $maxValue, $coefficient, $gradedAt, $comment, $id, $userId]);
    }

    public static function delete(int $id, int $userId): void
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare('DELETE FROM grades WHERE id = ? AND user_id = ?');
        $stmt->execute([$id, $userId]);
    }

    public static function getBySubjectGrouped(int $userId): array
    {
        $grades = self::getAllByUser($userId);
        $grouped = [];
        foreach ($grades as $g) {
            $sid = $g['subject_id'];
            if (!isset($grouped[$sid])) {
                $grouped[$sid] = [
                    'subject_id'    => $sid,
                    'subject_name'  => $g['subject_name'],
                    'subject_color' => $g['subject_color'],
                    'grades'        => [],
                    'average'       => null,
                ];
            }
            $grouped[$sid]['grades'][] = $g;
        }
        // Compute weighted average per subject
        foreach ($grouped as $sid => &$group) {
            $sumW = 0.0;
            $sumC = 0.0;
            foreach ($group['grades'] as $g) {
                $coeff = (float) $g['coefficient'];
                $sumW += ($g['value'] / $g['max_value'] * 20) * $coeff;
                $sumC += $coeff;
            }
            $group['average'] = $sumC > 0 ? $sumW / $sumC : null;
        }
        unset($group);
        return $grouped;
    }
}
