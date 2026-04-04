<?php

namespace EduSync\Models;

use EduSync\Core\Database;

class Document
{
    private const ALLOWED_MIME_TYPES = [
        'application/pdf',
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/webp',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'application/vnd.ms-powerpoint',
        'text/plain',
    ];

    public static function getAllByChapter(int $chapterId): array
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'SELECT id, chapter_id, title, description, original_name, file_type, created_at
             FROM documents WHERE chapter_id = ? ORDER BY created_at DESC'
        );
        $stmt->execute([$chapterId]);
        return $stmt->fetchAll();
    }

    /**
     * Returns document metadata + content for a document, checking ownership via user_id.
     * Use for serve/download only (fetches BLOB).
     */
    public static function getByIdForUser(int $id, int $userId): array|false
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'SELECT d.*, c.name AS chapter_name, c.color AS chapter_color,
                    t.name AS theme_name, t.id AS theme_id,
                    s.name AS subject_name, s.id AS subject_id
             FROM documents d
             JOIN chapters c ON d.chapter_id  = c.id
             JOIN themes t   ON c.theme_id    = t.id
             JOIN subjects s ON t.subject_id  = s.id
             WHERE d.id = ? AND s.user_id = ?'
        );
        $stmt->execute([$id, $userId]);
        return $stmt->fetch();
    }

    /**
     * Returns document metadata without content (for view/edit pages).
     */
    public static function getMetaByIdForUser(int $id, int $userId): array|false
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'SELECT d.id, d.chapter_id, d.title, d.description, d.original_name, d.file_type,
                    d.created_at, d.updated_at,
                    c.name AS chapter_name, c.color AS chapter_color,
                    t.name AS theme_name, t.id AS theme_id,
                    s.name AS subject_name, s.id AS subject_id
             FROM documents d
             JOIN chapters c ON d.chapter_id  = c.id
             JOIN themes t   ON c.theme_id    = t.id
             JOIN subjects s ON t.subject_id  = s.id
             WHERE d.id = ? AND s.user_id = ?'
        );
        $stmt->execute([$id, $userId]);
        return $stmt->fetch();
    }

    /**
     * Updates title, description, and optionally replaces the file content.
     */
    public static function update(int $id, string $title, string $description, ?array $file = null): void
    {
        $db = Database::getInstance();

        if ($file !== null && $file['error'] === UPLOAD_ERR_OK) {
            $mimeType = mime_content_type($file['tmp_name']);
            if (!in_array($mimeType, self::ALLOWED_MIME_TYPES, true)) {
                throw new \RuntimeException('File type not allowed: ' . $mimeType);
            }
            $content      = file_get_contents($file['tmp_name']);
            $originalName = basename($file['name']);
            $stmt = $db->prepare(
                'UPDATE documents SET title = ?, description = ?, original_name = ?, file_type = ?, content = ? WHERE id = ?'
            );
            $stmt->execute([$title, $description ?: null, $originalName, $mimeType, $content, $id]);
        } else {
            $stmt = $db->prepare(
                'UPDATE documents SET title = ?, description = ? WHERE id = ?'
            );
            $stmt->execute([$title, $description ?: null, $id]);
        }
    }

    /**
     * Validates and stores an uploaded file in the database.
     * Returns the new document id, or throws on error.
     */
    public static function upload(
        int    $chapterId,
        string $title,
        string $description,
        array  $file
    ): int {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $messages = [
                UPLOAD_ERR_INI_SIZE  => 'File is too large. Maximum allowed is 50 MB.',
                UPLOAD_ERR_FORM_SIZE => 'File is too large (form limit exceeded).',
                UPLOAD_ERR_PARTIAL   => 'File was only partially uploaded.',
                UPLOAD_ERR_NO_FILE   => 'No file was uploaded.',
            ];
            throw new \RuntimeException($messages[$file['error']] ?? 'Upload failed (error ' . $file['error'] . ').');
        }

        if ($file['size'] > 50 * 1024 * 1024) {
            throw new \RuntimeException('File too large. Maximum size is 50 MB.');
        }

        $mimeType = mime_content_type($file['tmp_name']);
        if (!in_array($mimeType, self::ALLOWED_MIME_TYPES, true)) {
            throw new \RuntimeException('File type not allowed: ' . $mimeType);
        }

        $content      = file_get_contents($file['tmp_name']);
        $originalName = basename($file['name']);

        $db   = Database::getInstance();
        $stmt = $db->prepare(
            'INSERT INTO documents (chapter_id, title, description, original_name, file_type, content)
             VALUES (?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $chapterId,
            $title,
            $description ?: null,
            $originalName,
            $mimeType,
            $content,
        ]);
        return (int) $db->lastInsertId();
    }

    public static function delete(int $id): void
    {
        $db   = Database::getInstance();
        $stmt = $db->prepare('DELETE FROM documents WHERE id = ?');
        $stmt->execute([$id]);
    }

    public static function createNote(int $chapterId, string $title, string $description, string $htmlContent): int
    {
        $content = self::sanitizeNoteHtml($htmlContent);
        $db      = Database::getInstance();
        $stmt    = $db->prepare(
            'INSERT INTO documents (chapter_id, title, description, original_name, file_type, content)
             VALUES (?, ?, ?, ?, ?, ?)'
        );
        $stmt->execute([
            $chapterId,
            $title,
            $description ?: null,
            $title . '.html',
            'text/html',
            $content,
        ]);
        return (int) $db->lastInsertId();
    }

    public static function updateNote(int $id, string $title, string $description, string $htmlContent): void
    {
        $content = self::sanitizeNoteHtml($htmlContent);
        $db      = Database::getInstance();
        $stmt    = $db->prepare(
            'UPDATE documents SET title = ?, description = ?, original_name = ?, content = ? WHERE id = ?'
        );
        $stmt->execute([$title, $description ?: null, $title . '.html', $content, $id]);
    }

    private static function sanitizeNoteHtml(string $html): string
    {
        $safe = strip_tags($html, '<p><div><br><b><strong><i><em><u><s><strike><h1><h2><h3><ul><ol><li><span><sup><sub><hr><font>');
        $safe = preg_replace('/\s+on\w+\s*=\s*"[^"]*"/i', '', $safe);
        $safe = preg_replace('/\s+on\w+\s*=\s*\'[^\']*\'/i', '', $safe);
        return $safe;
    }
}
