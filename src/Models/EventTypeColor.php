<?php

namespace EduSync\Models;

use EduSync\Core\Database;

class EventTypeColor
{
    const DEFAULTS = [
        'exam'     => ['label' => 'Exam',     'color' => '#ef4444'],
        'vacation' => ['label' => 'Vacation', 'color' => '#22c55e'],
        'outing'   => ['label' => 'Outing',   'color' => '#3b82f6'],
        'reminder' => ['label' => 'Reminder', 'color' => '#f59e0b'],
        'other'    => ['label' => 'Other',    'color' => '#6366f1'],
    ];

    // Returns ['type_key' => ['label' => 'Exam', 'color' => '#ef4444'], ...]
    public static function getByUser(int $userId): array
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'SELECT type, label, color FROM event_type_colors WHERE user_id = ? ORDER BY id ASC'
        );
        $stmt->execute([$userId]);
        $rows = $stmt->fetchAll();

        if (empty($rows)) {
            self::initDefaults($userId);
            return self::getByUser($userId);
        }

        $result = [];
        foreach ($rows as $row) {
            $result[$row['type']] = ['label' => $row['label'], 'color' => $row['color']];
        }
        return $result;
    }

    // Returns [['id', 'type', 'label', 'color'], ...] for settings CRUD
    public static function getAllByUser(int $userId): array
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'SELECT id, type, label, color FROM event_type_colors WHERE user_id = ? ORDER BY id ASC'
        );
        $stmt->execute([$userId]);
        $rows = $stmt->fetchAll();

        if (empty($rows)) {
            self::initDefaults($userId);
            return self::getAllByUser($userId);
        }

        return $rows;
    }

    public static function initDefaults(int $userId): void
    {
        foreach (self::DEFAULTS as $type => $info) {
            self::insert($userId, $type, $info['label'], $info['color']);
        }
    }

    public static function insert(int $userId, string $type, string $label, string $color): void
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'INSERT IGNORE INTO event_type_colors (user_id, type, label, color) VALUES (?, ?, ?, ?)'
        );
        $stmt->execute([$userId, $type, $label, $color]);
    }

    public static function getById(int $id, int $userId): array|false
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare('SELECT id, type, label, color FROM event_type_colors WHERE id = ? AND user_id = ?');
        $stmt->execute([$id, $userId]);
        return $stmt->fetch();
    }

    public static function updateById(int $id, int $userId, string $label, string $color): void
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'UPDATE event_type_colors SET label = ?, color = ? WHERE id = ? AND user_id = ?'
        );
        $stmt->execute([$label, $color, $id, $userId]);
    }

    public static function deleteById(int $id, int $userId): void
    {
        $db   = Database::getInstance();
        $countStmt = $db->prepare('SELECT COUNT(*) FROM event_type_colors WHERE user_id = ?');
        $countStmt->execute([$userId]);
        if ((int) $countStmt->fetchColumn() <= 1) {
            return;
        }
        $stmt = $db->prepare('DELETE FROM event_type_colors WHERE id = ? AND user_id = ?');
        $stmt->execute([$id, $userId]);
    }
}
