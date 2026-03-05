<?php

namespace EduSync\Models;

use EduSync\Core\Database;

class RevisionPreset
{
    public static function getByUser(int $userId): array
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'SELECT * FROM revision_presets WHERE user_id = ? ORDER BY is_default DESC, name ASC'
        );
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public static function getById(int $id, int $userId): ?array
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare('SELECT * FROM revision_presets WHERE id = ? AND user_id = ?');
        $stmt->execute([$id, $userId]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function getDefault(int $userId): ?array
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare('SELECT * FROM revision_presets WHERE user_id = ? AND is_default = 1 LIMIT 1');
        $stmt->execute([$userId]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function create(int $userId, string $name, array $intervals): void
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'INSERT INTO revision_presets (user_id, name, intervals) VALUES (?, ?, ?)'
        );
        $stmt->execute([$userId, $name, json_encode($intervals)]);
    }

    public static function update(int $id, int $userId, string $name, array $intervals): void
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'UPDATE revision_presets SET name = ?, intervals = ? WHERE id = ? AND user_id = ?'
        );
        $stmt->execute([$name, json_encode($intervals), $id, $userId]);
    }

    public static function delete(int $id, int $userId): void
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare('DELETE FROM revision_presets WHERE id = ? AND user_id = ?');
        $stmt->execute([$id, $userId]);
    }

    public static function setDefault(int $id, int $userId): void
    {
        $db = Database::getInstance();
        $db->prepare('UPDATE revision_presets SET is_default = 0 WHERE user_id = ?')->execute([$userId]);
        $db->prepare('UPDATE revision_presets SET is_default = 1 WHERE id = ? AND user_id = ?')->execute([$id, $userId]);
    }

    public static function unsetDefault(int $userId): void
    {
        $db = Database::getInstance();
        $db->prepare('UPDATE revision_presets SET is_default = 0 WHERE user_id = ?')->execute([$userId]);
    }

    /**
     * Parse and validate steps from POST (preset form).
     * Each step is ['day' => int, 'action' => string].
     * Returns null if invalid (missing days, non-integer, etc.).
     *
     * @param array $rawSteps  e.g. [['day' => '1', 'action' => 'Relire le cours'], ...]
     */
    public static function parseSteps(array $rawSteps): ?array
    {
        if (empty($rawSteps)) {
            return null;
        }
        $steps = [];
        foreach ($rawSteps as $raw) {
            $day    = trim($raw['day'] ?? '');
            $action = trim($raw['action'] ?? '');
            if (!ctype_digit($day) || (int) $day < 0) {
                return null;
            }
            $steps[] = ['day' => (int) $day, 'action' => $action];
        }
        return $steps;
    }

    /**
     * Parse a comma-separated day string (custom mode in add-item form).
     * Returns steps with empty actions, or null if invalid.
     */
    public static function parseIntervals(string $raw): ?array
    {
        $parts = array_filter(array_map('trim', explode(',', $raw)));
        if (empty($parts)) {
            return null;
        }
        $steps = [];
        foreach ($parts as $p) {
            if (!ctype_digit($p)) {
                return null;
            }
            $steps[] = ['day' => (int) $p, 'action' => ''];
        }
        return $steps;
    }
}
