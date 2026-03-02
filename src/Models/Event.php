<?php

namespace EduSync\Models;

use EduSync\Core\Database;

class Event
{
    public static function getWeekByUser(int $userId): array
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'SELECT * FROM events
             WHERE user_id = ?
               AND start_date >= CURDATE()
               AND start_date < CURDATE() + INTERVAL 7 DAY
             ORDER BY start_date ASC'
        );
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
}
