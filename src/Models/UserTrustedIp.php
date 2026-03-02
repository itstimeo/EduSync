<?php

namespace EduSync\Models;

use EduSync\Core\Database;

class UserTrustedIp
{
    public static function isTrusted(int $userId, string $ip): bool
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'SELECT id FROM user_trusted_ips WHERE user_id = ? AND ip_address = ? LIMIT 1'
        );
        $stmt->execute([$userId, $ip]);
        return (bool) $stmt->fetch();
    }

    public static function addTrusted(int $userId, string $ip, ?string $userAgent = null): void
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'INSERT INTO user_trusted_ips (user_id, ip_address, user_agent)
             VALUES (?, ?, ?)
             ON DUPLICATE KEY UPDATE user_agent = VALUES(user_agent), last_seen_at = NOW()'
        );
        $stmt->execute([$userId, $ip, $userAgent]);
    }

    public static function updateLastSeen(int $userId, string $ip): void
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'UPDATE user_trusted_ips SET last_seen_at = NOW() WHERE user_id = ? AND ip_address = ?'
        );
        $stmt->execute([$userId, $ip]);
    }
}
