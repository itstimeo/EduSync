<?php

namespace EduSync\Models;

use EduSync\Core\Database;

class RevisionSession
{
    public static function getTodayByUser(int $userId): array
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'SELECT rs.*,
                CASE rs.item_type
                    WHEN \'chapter\'  THEN c.name
                    WHEN \'document\' THEN d.title
                END AS item_name
             FROM revision_sessions rs
             LEFT JOIN chapters  c ON rs.item_type = \'chapter\'  AND rs.item_id = c.id
             LEFT JOIN documents d ON rs.item_type = \'document\' AND rs.item_id = d.id
             WHERE rs.user_id = ? AND rs.next_revision_date <= CURDATE()
             ORDER BY rs.next_revision_date ASC'
        );
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
}
