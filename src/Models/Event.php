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

    public static function getByMonth(int $userId, string $firstDay, string $lastDay): array
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'SELECT * FROM events WHERE user_id = ? AND start_date <= ? ORDER BY start_date ASC'
        );
        $stmt->execute([$userId, $lastDay]);
        $all = $stmt->fetchAll();

        return array_values(array_filter($all, function ($e) use ($firstDay) {
            $start = substr($e['start_date'], 0, 10);
            $end   = (isset($e['end_date']) && $e['end_date'] && $e['end_date'] !== '0000-00-00')
                ? substr($e['end_date'], 0, 10)
                : $start;
            return $end >= $firstDay;
        }));
    }

    public static function getUpcoming(int $userId): array
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'SELECT * FROM events
             WHERE user_id = ?
               AND (end_date >= CURDATE() OR (end_date IS NULL AND start_date >= CURDATE()))
             ORDER BY start_date ASC'
        );
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public static function getByIdAndUser(int $id, int $userId): array|false
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare('SELECT * FROM events WHERE id = ? AND user_id = ?');
        $stmt->execute([$id, $userId]);
        return $stmt->fetch();
    }

    public static function create(
        int $userId, string $title, string $type, string $color,
        string $startDate, ?string $endDate, ?string $description
    ): int {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'INSERT INTO events (user_id, title, type, color, start_date, end_date, description)
             VALUES (?, ?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([$userId, $title, $type, $color, $startDate, $endDate, $description]);
        return (int) $db->lastInsertId();
    }

    public static function update(
        int $id, int $userId, string $title, string $type, string $color,
        string $startDate, ?string $endDate, ?string $description
    ): void {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'UPDATE events
             SET title = ?, type = ?, color = ?, start_date = ?, end_date = ?, description = ?
             WHERE id = ? AND user_id = ?'
        );
        $stmt->execute([$title, $type, $color, $startDate, $endDate, $description, $id, $userId]);
    }

    public static function deleteByType(int $userId, string $type): void
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare('DELETE FROM events WHERE user_id = ? AND type = ?');
        $stmt->execute([$userId, $type]);
    }

    public static function updateColorByType(int $userId, string $type, string $color): void
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare('UPDATE events SET color = ? WHERE user_id = ? AND type = ?');
        $stmt->execute([$color, $userId, $type]);
    }

    public static function delete(int $id, int $userId): void
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare('DELETE FROM events WHERE id = ? AND user_id = ?');
        $stmt->execute([$id, $userId]);
    }
}
