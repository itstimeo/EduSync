<?php

namespace EduSync\Models;

use EduSync\Core\Database;

class GoogleToken
{
    public static function getByUser(int $userId): ?array
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare('SELECT * FROM google_tokens WHERE user_id = ?');
        $stmt->execute([$userId]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function upsert(
        int $userId,
        string $accessToken,
        ?string $refreshToken,
        string $expiresAt,
        ?string $googleEmail
    ): void {
        $db = Database::getInstance();
        $stmt = $db->prepare(
            'INSERT INTO google_tokens (user_id, access_token, refresh_token, token_expires_at, google_email)
             VALUES (?, ?, ?, ?, ?)
             ON DUPLICATE KEY UPDATE
                access_token     = VALUES(access_token),
                refresh_token    = COALESCE(VALUES(refresh_token), refresh_token),
                token_expires_at = VALUES(token_expires_at),
                google_email     = VALUES(google_email)'
        );
        $stmt->execute([$userId, $accessToken, $refreshToken, $expiresAt, $googleEmail]);
    }

    public static function updateAccessToken(int $userId, string $accessToken, string $expiresAt): void
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'UPDATE google_tokens SET access_token = ?, token_expires_at = ? WHERE user_id = ?'
        );
        $stmt->execute([$accessToken, $expiresAt, $userId]);
    }

    public static function delete(int $userId): void
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare('DELETE FROM google_tokens WHERE user_id = ?');
        $stmt->execute([$userId]);
    }
}
