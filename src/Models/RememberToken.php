<?php

namespace EduSync\Models;

use EduSync\Core\Database;

class RememberToken
{
    public static function create(int $userId, string $tokenHash, string $expiresAt): void
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'INSERT INTO remember_tokens (user_id, token_hash, expires_at) VALUES (?, ?, ?)'
        );
        $stmt->execute([$userId, $tokenHash, $expiresAt]);
    }

    public static function findByHash(string $tokenHash): ?array
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'SELECT * FROM remember_tokens WHERE token_hash = ? LIMIT 1'
        );
        $stmt->execute([$tokenHash]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function updateLastUsed(int $id): void
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare('UPDATE remember_tokens SET last_used_at = NOW() WHERE id = ?');
        $stmt->execute([$id]);
    }

    public static function deleteByHash(string $tokenHash): void
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare('DELETE FROM remember_tokens WHERE token_hash = ?');
        $stmt->execute([$tokenHash]);
    }

    public static function deleteByUserId(int $userId): void
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare('DELETE FROM remember_tokens WHERE user_id = ?');
        $stmt->execute([$userId]);
    }
}
