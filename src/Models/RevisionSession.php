<?php

namespace EduSync\Models;

use EduSync\Core\Database;

class RevisionSession
{
    private const DEFAULT_INTERVALS = [
        ['day' => 1,  'action' => ''],
        ['day' => 3,  'action' => ''],
        ['day' => 7,  'action' => ''],
        ['day' => 14, 'action' => ''],
        ['day' => 30, 'action' => ''],
    ];

    private static function sessionSelectSql(string $whereClause): string
    {
        return "SELECT rs.*,
                CASE rs.item_type
                    WHEN 'chapter'  THEN c.name
                    WHEN 'document' THEN d.title
                END AS item_name,
                CASE rs.item_type
                    WHEN 'chapter'  THEN s1.color
                    WHEN 'document' THEN s2.color
                END AS subject_color
             FROM revision_sessions rs
             LEFT JOIN chapters  c  ON rs.item_type = 'chapter'  AND rs.item_id = c.id
             LEFT JOIN themes    t1 ON c.theme_id = t1.id
             LEFT JOIN subjects  s1 ON t1.subject_id = s1.id
             LEFT JOIN documents d  ON rs.item_type = 'document' AND rs.item_id = d.id
             LEFT JOIN chapters  c2 ON d.chapter_id = c2.id
             LEFT JOIN themes    t2 ON c2.theme_id = t2.id
             LEFT JOIN subjects  s2 ON t2.subject_id = s2.id
             WHERE $whereClause
             ORDER BY rs.next_revision_date ASC";
    }

    public static function getTodayByUser(int $userId): array
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(self::sessionSelectSql(
            'rs.user_id = ? AND (rs.next_revision_date <= CURDATE() OR rs.reviewed_today = CURDATE())'
        ));
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public static function getUpcomingByUser(int $userId): array
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(self::sessionSelectSql(
            'rs.user_id = ? AND rs.next_revision_date > CURDATE() AND (rs.reviewed_today IS NULL OR rs.reviewed_today != CURDATE())'
        ));
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public static function create(int $userId, string $itemType, int $itemId, array $intervals, string $startDate = ''): void
    {
        $firstDay  = (int) ($intervals[0]['day'] ?? 1);
        $db        = Database::getInstance();
        $baseDate  = ($startDate !== '') ? $startDate : date('Y-m-d');
        $stmt      = $db->prepare(
            'INSERT INTO revision_sessions (user_id, item_type, item_id, intervals, interval_index, start_date, next_revision_date)
             VALUES (?, ?, ?, ?, 0, ?, DATE_ADD(?, INTERVAL ? DAY))'
        );
        $stmt->execute([$userId, $itemType, $itemId, json_encode($intervals), $baseDate, $baseDate, $firstDay]);
    }

    public static function getById(int $id, int $userId): ?array
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare('SELECT * FROM revision_sessions WHERE id = ? AND user_id = ?');
        $stmt->execute([$id, $userId]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function toggle(int $id, int $userId): bool
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare('SELECT * FROM revision_sessions WHERE id = ? AND user_id = ?');
        $stmt->execute([$id, $userId]);
        $session = $stmt->fetch();
        if (!$session) {
            return false;
        }

        $isChecked = ($session['reviewed_today'] === date('Y-m-d'));

        if ($isChecked) {
            // Uncheck: revert interval by one step, put back as due today
            $prevIndex = max(0, (int)$session['interval_index'] - 1);
            $db->prepare(
                'UPDATE revision_sessions SET interval_index = ?, next_revision_date = CURDATE(), reviewed_today = NULL WHERE id = ? AND user_id = ?'
            )->execute([$prevIndex, $id, $userId]);
            return false;
        }

        // Check: advance interval
        $intervals = json_decode($session['intervals'], true) ?: self::DEFAULT_INTERVALS;
        $nextIndex = (int)$session['interval_index'] + 1;

        if ($nextIndex >= count($intervals)) {
            // Last step — mastered
            $db->prepare('DELETE FROM revision_sessions WHERE id = ? AND user_id = ?')->execute([$id, $userId]);
        } else {
            $days = (int)($intervals[$nextIndex]['day'] ?? 1);
            $db->prepare(
                'UPDATE revision_sessions SET interval_index = ?, next_revision_date = DATE_ADD(CURDATE(), INTERVAL ? DAY), reviewed_today = CURDATE() WHERE id = ? AND user_id = ?'
            )->execute([$nextIndex, $days, $id, $userId]);
        }
        return true;
    }

    public static function editSession(int $id, int $userId, string $startDate, array $intervals): void
    {
        $firstDay = (int) ($intervals[0]['day'] ?? 1);
        $db       = Database::getInstance();
        $db->prepare(
            'UPDATE revision_sessions
             SET start_date = ?, intervals = ?, interval_index = 0,
                 next_revision_date = DATE_ADD(?, INTERVAL ? DAY),
                 reviewed_today = NULL
             WHERE id = ? AND user_id = ?'
        )->execute([$startDate, json_encode($intervals), $startDate, $firstDay, $id, $userId]);
    }

    public static function markDone(int $id, int $userId): void
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare('SELECT * FROM revision_sessions WHERE id = ? AND user_id = ?');
        $stmt->execute([$id, $userId]);
        $session = $stmt->fetch();
        if (!$session) {
            return;
        }

        $intervals  = json_decode($session['intervals'], true) ?: self::DEFAULT_INTERVALS;
        $nextIndex  = (int) $session['interval_index'] + 1;

        if ($nextIndex >= count($intervals)) {
            // All intervals done — item mastered
            $db->prepare('DELETE FROM revision_sessions WHERE id = ? AND user_id = ?')->execute([$id, $userId]);
        } else {
            $days = (int) ($intervals[$nextIndex]['day'] ?? 1);
            $db->prepare(
                'UPDATE revision_sessions
                 SET interval_index = ?, next_revision_date = DATE_ADD(CURDATE(), INTERVAL ? DAY)
                 WHERE id = ? AND user_id = ?'
            )->execute([$nextIndex, $days, $id, $userId]);
        }
    }

    public static function delete(int $id, int $userId): void
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare('DELETE FROM revision_sessions WHERE id = ? AND user_id = ?');
        $stmt->execute([$id, $userId]);
    }

    public static function getAvailableChapters(int $userId): array
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'SELECT c.id, c.name AS chapter_name, s.name AS subject_name, s.color AS subject_color
             FROM chapters c
             JOIN themes t ON c.theme_id = t.id
             JOIN subjects s ON t.subject_id = s.id
             WHERE s.user_id = ?
               AND NOT EXISTS (
                 SELECT 1 FROM revision_sessions rs2
                 WHERE rs2.user_id = ? AND rs2.item_type = \'chapter\' AND rs2.item_id = c.id
               )
             ORDER BY s.name ASC, c.name ASC'
        );
        $stmt->execute([$userId, $userId]);
        return $stmt->fetchAll();
    }

    public static function getAvailableDocuments(int $userId): array
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'SELECT d.id, d.title AS document_title, c.name AS chapter_name, s.name AS subject_name, s.color AS subject_color
             FROM documents d
             JOIN chapters c ON d.chapter_id = c.id
             JOIN themes t ON c.theme_id = t.id
             JOIN subjects s ON t.subject_id = s.id
             WHERE s.user_id = ?
               AND NOT EXISTS (
                 SELECT 1 FROM revision_sessions rs2
                 WHERE rs2.user_id = ? AND rs2.item_type = \'document\' AND rs2.item_id = d.id
               )
             ORDER BY s.name ASC, d.title ASC'
        );
        $stmt->execute([$userId, $userId]);
        return $stmt->fetchAll();
    }
}
