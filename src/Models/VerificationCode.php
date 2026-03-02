<?php

namespace EduSync\Models;

use EduSync\Core\Database;

class VerificationCode
{
    public static function create(int $userId, string $code, string $type, int $minutesTtl = 15): void
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'INSERT INTO verification_codes (user_id, code, type, expires_at)
             VALUES (?, ?, ?, DATE_ADD(NOW(), INTERVAL ? MINUTE))'
        );
        $stmt->execute([$userId, $code, $type, $minutesTtl]);
    }

    public static function findValid(int $userId, string $code, string $type): ?array
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'SELECT * FROM verification_codes
             WHERE user_id = ? AND code = ? AND type = ?
               AND used_at IS NULL AND expires_at > NOW()
             ORDER BY created_at DESC
             LIMIT 1'
        );
        $stmt->execute([$userId, $code, $type]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function markUsed(int $id): void
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare('UPDATE verification_codes SET used_at = NOW() WHERE id = ?');
        $stmt->execute([$id]);
    }
}
