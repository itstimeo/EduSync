<?php

namespace EduSync\Services;

use EduSync\Models\GoogleToken;

class GoogleCalendarService
{
    private const AUTH_URL    = 'https://accounts.google.com/o/oauth2/v2/auth';
    private const TOKEN_URL   = 'https://oauth2.googleapis.com/token';
    private const CALENDAR_API = 'https://www.googleapis.com/calendar/v3';
    private const SCOPES      = 'openid email https://www.googleapis.com/auth/calendar.events';

    public static function getAuthUrl(string $state): string
    {
        return self::AUTH_URL . '?' . http_build_query([
            'client_id'     => GOOGLE_CLIENT_ID,
            'redirect_uri'  => GOOGLE_REDIRECT_URI,
            'response_type' => 'code',
            'scope'         => self::SCOPES,
            'access_type'   => 'offline',
            'prompt'        => 'consent',
            'state'         => $state,
        ]);
    }

    public static function handleCallback(string $code, int $userId): void
    {
        $response = self::postForm(self::TOKEN_URL, [
            'code'          => $code,
            'client_id'     => GOOGLE_CLIENT_ID,
            'client_secret' => GOOGLE_CLIENT_SECRET,
            'redirect_uri'  => GOOGLE_REDIRECT_URI,
            'grant_type'    => 'authorization_code',
        ]);

        if (!isset($response['access_token'])) {
            throw new \RuntimeException('Failed to obtain access token from Google.');
        }

        $expiresAt    = date('Y-m-d H:i:s', time() + (int) ($response['expires_in'] ?? 3600));
        $refreshToken = $response['refresh_token'] ?? null;
        $googleEmail  = self::extractEmailFromIdToken($response['id_token'] ?? '');

        GoogleToken::upsert($userId, $response['access_token'], $refreshToken, $expiresAt, $googleEmail);
    }

    public static function isConnected(int $userId): bool
    {
        return GoogleToken::getByUser($userId) !== null;
    }

    public static function pushEvent(int $userId, array $event): ?string
    {
        $token = self::getValidToken($userId);
        if (!$token) return null;

        $body   = self::buildEventBody($event);
        $gcalId = $event['gcal_event_id'] ?? null;

        if ($gcalId) {
            $response = self::request(
                'PUT',
                self::CALENDAR_API . '/calendars/primary/events/' . urlencode($gcalId),
                $body,
                $token['access_token']
            );
        } else {
            $response = self::request(
                'POST',
                self::CALENDAR_API . '/calendars/primary/events',
                $body,
                $token['access_token']
            );
        }

        return $response['id'] ?? null;
    }

    public static function deleteEvent(int $userId, string $gcalEventId): void
    {
        $token = self::getValidToken($userId);
        if (!$token) return;

        self::request(
            'DELETE',
            self::CALENDAR_API . '/calendars/primary/events/' . urlencode($gcalEventId),
            null,
            $token['access_token']
        );
    }

    // ─────────────────────────────────────────────────────────────
    // Private helpers
    // ─────────────────────────────────────────────────────────────

    private static function getValidToken(int $userId): ?array
    {
        $token = GoogleToken::getByUser($userId);
        if (!$token) return null;

        if (strtotime($token['token_expires_at']) <= time() + 60) {
            if (!$token['refresh_token']) return null;
            if (!self::refreshToken($userId, $token['refresh_token'])) return null;
            $token = GoogleToken::getByUser($userId);
        }

        return $token;
    }

    private static function refreshToken(int $userId, string $refreshToken): bool
    {
        $response = self::postForm(self::TOKEN_URL, [
            'client_id'     => GOOGLE_CLIENT_ID,
            'client_secret' => GOOGLE_CLIENT_SECRET,
            'refresh_token' => $refreshToken,
            'grant_type'    => 'refresh_token',
        ]);

        if (!isset($response['access_token'])) return false;

        $expiresAt = date('Y-m-d H:i:s', time() + (int) ($response['expires_in'] ?? 3600));
        GoogleToken::updateAccessToken($userId, $response['access_token'], $expiresAt);
        return true;
    }

    // Google Calendar colorId → hex (source: Calendar API docs)
    private const GCAL_COLORS = [
        '1'  => [121, 134, 203], // Lavender
        '2'  => [ 51, 182, 121], // Sage
        '3'  => [142,  36, 170], // Grape
        '4'  => [230, 124, 115], // Flamingo
        '5'  => [246, 191,  38], // Banana
        '6'  => [245,  81,  29], // Tangerine
        '7'  => [  3, 155, 229], // Peacock
        '8'  => [ 63,  81, 181], // Blueberry
        '9'  => [ 15, 157,  88], // Basil
        '10' => [213,   0,   0], // Tomato
        '11' => [ 97,  97,  97], // Graphite
    ];

    private static function hexToColorId(string $hex): string
    {
        $hex = ltrim($hex, '#');
        if (strlen($hex) !== 6) return '1';

        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        $best = '1';
        $bestDist = PHP_INT_MAX;
        foreach (self::GCAL_COLORS as $id => $rgb) {
            $dist = ($r - $rgb[0]) ** 2 + ($g - $rgb[1]) ** 2 + ($b - $rgb[2]) ** 2;
            if ($dist < $bestDist) {
                $bestDist = $dist;
                $best = $id;
            }
        }
        return $best;
    }

    private static function buildEventBody(array $event): array
    {
        $start = substr($event['start_date'], 0, 10);
        $end   = (isset($event['end_date']) && $event['end_date'] && $event['end_date'] !== '0000-00-00')
            ? substr($event['end_date'], 0, 10)
            : $start;
        // All-day events: end date is exclusive in Google Calendar API
        $endExclusive = date('Y-m-d', strtotime($end . ' +1 day'));

        $body = [
            'summary' => $event['title'],
            'start'   => ['date' => $start],
            'end'     => ['date' => $endExclusive],
            'colorId' => self::hexToColorId($event['color'] ?? ''),
        ];

        if (!empty($event['description'])) {
            $body['description'] = $event['description'];
        }

        return $body;
    }

    private static function extractEmailFromIdToken(string $idToken): ?string
    {
        $parts = explode('.', $idToken);
        if (count($parts) < 2) return null;

        $padded  = str_pad(strtr($parts[1], '-_', '+/'), (int) ceil(strlen($parts[1]) / 4) * 4, '=');
        $payload = json_decode(base64_decode($padded), true);
        return $payload['email'] ?? null;
    }

    private static function request(string $method, string $url, ?array $data, string $accessToken): array
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $accessToken,
            'Content-Type: application/json',
        ]);

        if ($data !== null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $result = curl_exec($ch);
        curl_close($ch);

        if (!$result) return [];
        return json_decode($result, true) ?? [];
    }

    private static function postForm(string $url, array $data): array
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result, true) ?? [];
    }
}
