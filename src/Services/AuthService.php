<?php

namespace EduSync\Services;

use EduSync\Core\Database;
use EduSync\Core\Session;
use EduSync\Models\RememberToken;
use EduSync\Models\User;
use EduSync\Models\UserTrustedIp;
use EduSync\Models\VerificationCode;

class AuthService
{
    public static function register(string $email, string $password, string $firstName, string $lastName): array
    {
        if (strlen($password) < 8) {
            return ['ok' => false, 'error' => 'Password must be at least 8 characters.'];
        }

        if (User::findByEmail($email)) {
            return ['ok' => false, 'error' => 'This email address is already in use.'];
        }

        $userId = User::create($email, $password, $firstName, $lastName);

        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        VerificationCode::create($userId, $code, 'email_verify', 15);

        try {
            MailService::send(
                $email,
                'EduSync — Verify your email address',
                self::buildEmailVerifyEmail($firstName, $code)
            );
        } catch (\Exception $e) {
            error_log('Mail send failed: ' . $e->getMessage());
            return ['ok' => false, 'error' => 'Failed to send verification email. Please try again.'];
        }

        Session::set('pending_verify_user_id', $userId);
        Session::set('pending_verify_first_name', $firstName);

        return ['ok' => true];
    }

    public static function attemptRememberLogin(): void
    {
        if (Session::has('user_id')) {
            return;
        }

        $raw = $_COOKIE['remember_token'] ?? null;
        if (!$raw) {
            return;
        }

        $hash   = hash('sha256', $raw);
        $record = RememberToken::findByHash($hash);

        if (!$record) {
            return;
        }

        $inactiveDays = (time() - strtotime($record['last_used_at'])) / 86400;
        if ($inactiveDays > REMEMBER_INACTIVE_DAYS) {
            RememberToken::deleteByHash($hash);
            setcookie('remember_token', '', time() - 3600, '/', '', false, true);
            return;
        }

        if (time() > strtotime($record['expires_at'])) {
            RememberToken::deleteByHash($hash);
            setcookie('remember_token', '', time() - 3600, '/', '', false, true);
            return;
        }

        // Rotation du token
        RememberToken::deleteByHash($hash);
        $newRaw    = bin2hex(random_bytes(32));
        $newHash   = hash('sha256', $newRaw);
        $expiresAt = $record['expires_at'];
        RememberToken::create((int) $record['user_id'], $newHash, $expiresAt);
        setcookie('remember_token', $newRaw, strtotime($expiresAt), '/', '', false, true);

        $db   = Database::getInstance();
        $stmt = $db->prepare('SELECT first_name FROM users WHERE id = ? LIMIT 1');
        $stmt->execute([$record['user_id']]);
        $user = $stmt->fetch();

        Session::set('user_id',       (int) $record['user_id']);
        Session::set('user_name',     $user['first_name'] ?? '');
        Session::set('last_activity', time());
    }

    public static function login(string $email, string $password, bool $rememberMe = false): array
    {
        $user = User::findByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            return ['ok' => false, 'error' => 'Invalid email or password.'];
        }

        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';

        if (UserTrustedIp::isTrusted((int) $user['id'], $ip)) {
            UserTrustedIp::updateLastSeen((int) $user['id'], $ip);
            Session::set('user_id', (int) $user['id']);
            Session::set('user_name', $user['first_name']);
            if ($rememberMe) {
                self::setRememberToken((int) $user['id']);
            }
            return ['ok' => true, 'trusted' => true];
        }

        $code = self::generateIpCode((int) $user['id']);

        try {
            MailService::send(
                $user['email'],
                'EduSync — New connection detected',
                self::buildIpCodeEmail($user['first_name'], $code)
            );
        } catch (\Exception $e) {
            error_log('Mail send failed: ' . $e->getMessage());
            return ['ok' => false, 'error' => 'Failed to send verification email. Please try again.'];
        }

        Session::set('pending_user_id', (int) $user['id']);

        return ['ok' => true, 'trusted' => false];
    }

    public static function verifyEmailCode(int $userId, string $code): array
    {
        $record = VerificationCode::findValid($userId, $code, 'email_verify');

        if (!$record) {
            return ['ok' => false, 'error' => 'Invalid or expired verification code.'];
        }

        VerificationCode::markUsed((int) $record['id']);

        $ip        = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? null;
        UserTrustedIp::addTrusted($userId, $ip, $userAgent);

        $firstName = Session::get('pending_verify_first_name', '');
        Session::remove('pending_verify_user_id');
        Session::remove('pending_verify_first_name');
        Session::set('user_id', $userId);
        Session::set('user_name', $firstName);

        return ['ok' => true];
    }

    public static function generateIpCode(int $userId): string
    {
        $code = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        VerificationCode::create($userId, $code, 'new_ip', 15);
        return $code;
    }

    public static function verifyIpCode(int $userId, string $code): array
    {
        $record = VerificationCode::findValid($userId, $code, 'new_ip');

        if (!$record) {
            return ['ok' => false, 'error' => 'Invalid or expired verification code.'];
        }

        VerificationCode::markUsed((int) $record['id']);

        $ip        = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? null;
        UserTrustedIp::addTrusted($userId, $ip, $userAgent);

        $db   = \EduSync\Core\Database::getInstance();
        $stmt = $db->prepare('SELECT first_name FROM users WHERE id = ? LIMIT 1');
        $stmt->execute([$userId]);
        $row = $stmt->fetch();

        Session::remove('pending_user_id');
        Session::set('user_id', $userId);
        Session::set('user_name', $row['first_name'] ?? '');

        return ['ok' => true];
    }

    private static function setRememberToken(int $userId): void
    {
        $raw       = bin2hex(random_bytes(32));
        $hash      = hash('sha256', $raw);
        $expiresAt = date('Y-m-d H:i:s', strtotime('+' . REMEMBER_MAX_DAYS . ' days'));
        RememberToken::create($userId, $hash, $expiresAt);
        setcookie('remember_token', $raw, strtotime($expiresAt), '/', '', false, true);
    }

    private static function buildEmailVerifyEmail(string $firstName, string $code): string
    {
        return self::wrapEmail(
            htmlspecialchars($firstName),
            'Verify your email address',
            'Welcome to EduSync! Use the code below to verify your email address and activate your account.',
            htmlspecialchars($code),
            'This code expires in <strong>15 minutes</strong>.'
        );
    }

    private static function buildIpCodeEmail(string $firstName, string $code): string
    {
        return self::wrapEmail(
            htmlspecialchars($firstName),
            'New device detected',
            'A login attempt was made from an unrecognized device or IP address. Use the code below to confirm it\'s you.',
            htmlspecialchars($code),
            'This code expires in <strong>15 minutes</strong>. If you did not attempt to log in, you can safely ignore this email.'
        );
    }

    private static function wrapEmail(string $firstName, string $title, string $intro, string $code, string $footer): string
    {
        return '
        <!DOCTYPE html>
        <html lang="en">
        <head><meta charset="UTF-8"></head>
        <body style="margin:0;padding:0;background:#f4f4f5;font-family:system-ui,sans-serif;">
            <table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 0;">
                <tr>
                    <td align="center">
                        <table width="480" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:10px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,.08);">
                            <!-- Header -->
                            <tr>
                                <td style="background:#6366f1;padding:28px 40px;">
                                    <p style="margin:0;font-size:22px;font-weight:700;color:#ffffff;letter-spacing:-.3px;">EduSync</p>
                                </td>
                            </tr>
                            <!-- Body -->
                            <tr>
                                <td style="padding:36px 40px;">
                                    <p style="margin:0 0 6px;font-size:13px;color:#6b7280;text-transform:uppercase;letter-spacing:.05em;font-weight:600;">Security</p>
                                    <h1 style="margin:0 0 16px;font-size:22px;color:#111827;">' . $title . '</h1>
                                    <p style="margin:0 0 28px;font-size:15px;color:#4b5563;line-height:1.6;">Hello <strong>' . $firstName . '</strong>, ' . $intro . '</p>
                                    <!-- Code block -->
                                    <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:28px;">
                                        <tr>
                                            <td align="center" style="background:#f4f4f5;border-radius:8px;padding:20px;">
                                                <p style="margin:0 0 6px;font-size:12px;color:#9ca3af;text-transform:uppercase;letter-spacing:.1em;">Your code</p>
                                                <p style="margin:0;font-size:36px;font-weight:700;letter-spacing:.25em;color:#6366f1;">' . $code . '</p>
                                            </td>
                                        </tr>
                                    </table>
                                    <p style="margin:0;font-size:13px;color:#9ca3af;line-height:1.6;">' . $footer . '</p>
                                </td>
                            </tr>
                            <!-- Footer -->
                            <tr>
                                <td style="padding:20px 40px;border-top:1px solid #f3f4f6;">
                                    <p style="margin:0;font-size:12px;color:#d1d5db;text-align:center;">© EduSync — Do not reply to this email.</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </body>
        </html>';
    }
}
