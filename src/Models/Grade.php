<?php

namespace EduSync\Models;

use EduSync\Core\Database;

class Grade
{
    public static function getRecentByUser(int $userId, int $limit = 5): array
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'SELECT g.*, s.name AS subject_name
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
            'SELECT SUM(g.value / g.max_value * 20 * g.coefficient) / SUM(g.coefficient) AS average
             FROM grades g
             WHERE g.user_id = ?'
        );
        $stmt->execute([$userId]);
        $row = $stmt->fetch();
        return isset($row['average']) && $row['average'] !== null ? (float) $row['average'] : null;
    }
}
