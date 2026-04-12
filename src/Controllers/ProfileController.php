<?php

namespace EduSync\Controllers;

use EduSync\Core\Database;
use EduSync\Core\Session;
use EduSync\Core\View;
use EduSync\Models\GoogleToken;
use EduSync\Models\User;
use EduSync\Models\VerificationCode;
use EduSync\Services\MailService;

class ProfileController
{
    private function guard(): int
    {
        if (!Session::has('user_id')) {
            Session::redirect('/login');
        }
        return (int) Session::get('user_id');
    }

    public function show(): void
    {
        $userId = $this->guard();
        $user   = User::findById($userId);

        $gcalToken = GoogleToken::getByUser($userId);

        View::render('profile/index', [
            'title'       => 'Profile',
            'flash'       => Session::getFlash(),
            'userName'    => Session::get('user_name', ''),
            'user'        => $user,
            'gcalEmail'   => $gcalToken['google_email'] ?? null,
        ], 'layouts/app');
    }

    public function updateInfo(): void
    {
        $userId    = $this->guard();
        $firstName = trim($_POST['first_name'] ?? '');
        $lastName  = trim($_POST['last_name'] ?? '');

        if ($firstName === '' || $lastName === '') {
            Session::flash('error', 'First name and last name are required.');
            Session::redirect('/profile');
        }

        User::updateInfo($userId, $firstName, $lastName);
        Session::set('user_name', $firstName);
        Session::flash('success', 'Profile updated.');
        Session::redirect('/profile');
    }

    // Receives: $_FILES['photo'] (256×256 JPEG crop, always present)
    //           $_FILES['source'] (original image, only when a new file is uploaded)
    public function updatePhoto(): void
    {
        $userId = $this->guard();
        header('Content-Type: application/json');

        if (empty($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['ok' => false, 'error' => 'No crop received.']);
            return;
        }

        $avatar = file_get_contents($_FILES['photo']['tmp_name']);

        if (!empty($_FILES['source']) && $_FILES['source']['error'] === UPLOAD_ERR_OK) {
            $allowed = ['image/jpeg', 'image/png', 'image/webp'];
            $type    = $_FILES['source']['type'];
            if (!in_array($type, $allowed, true)) {
                echo json_encode(['ok' => false, 'error' => 'Invalid file type.']);
                return;
            }
            if ($_FILES['source']['size'] > 10 * 1024 * 1024) {
                echo json_encode(['ok' => false, 'error' => 'File too large (max 10 MB).']);
                return;
            }
            $original = file_get_contents($_FILES['source']['tmp_name']);
            User::savePhoto($userId, $avatar, $original, $type);
        } else {
            User::saveCrop($userId, $avatar);
        }

        echo json_encode(['ok' => true]);
    }

    public function deletePhoto(): void
    {
        $userId = $this->guard();
        User::deletePhoto($userId);
        Session::flash('success', 'Photo deleted.');
        Session::redirect('/profile');
    }

    public function servePhoto(): void
    {
        $userId = $this->guard();
        $photo  = User::getPhoto($userId);

        if (!$photo) {
            http_response_code(404);
            return;
        }

        header('Content-Type: ' . $photo['type']);
        header('Cache-Control: no-store');
        echo $photo['data'];
    }

    public function servePhotoSource(): void
    {
        $userId = $this->guard();
        $photo  = User::getPhotoSource($userId);

        if (!$photo) {
            http_response_code(404);
            return;
        }

        header('Content-Type: ' . $photo['type']);
        header('Cache-Control: no-store');
        echo $photo['data'];
    }

    public function requestEmailChange(): void
    {
        $userId = $this->guard();
        header('Content-Type: application/json');

        $currentEmail = trim($_POST['current_email'] ?? '');
        $newEmail     = trim($_POST['new_email'] ?? '');

        $db   = Database::getInstance();
        $stmt = $db->prepare('SELECT email, first_name FROM users WHERE id = ? LIMIT 1');
        $stmt->execute([$userId]);
        $row = $stmt->fetch();

        if (!$row || $currentEmail !== $row['email']) {
            echo json_encode(['ok' => false, 'error' => 'Current email does not match.']);
            return;
        }

        if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['ok' => false, 'error' => 'Invalid new email address.']);
            return;
        }

        if ($newEmail === $row['email']) {
            echo json_encode(['ok' => false, 'error' => 'New email is the same as the current one.']);
            return;
        }

        if (User::findByEmail($newEmail)) {
            echo json_encode(['ok' => false, 'error' => 'This email is already in use.']);
            return;
        }

        $codeOld = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $codeNew = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        VerificationCode::create($userId, $codeOld, 'email_change_old', 15);
        VerificationCode::create($userId, $codeNew, 'email_change_new', 15);

        try {
            MailService::send(
                $row['email'],
                'EduSync — Email change request',
                $this->buildEmailChangeCode($row['first_name'], $codeOld, 'your current email address')
            );
        } catch (\Exception $e) {
            error_log('Mail send failed: ' . $e->getMessage());
            echo json_encode(['ok' => false, 'error' => 'Failed to send email. Please try again.']);
            return;
        }

        try {
            MailService::send(
                $newEmail,
                'EduSync — Confirm your new email address',
                $this->buildEmailChangeCode($row['first_name'], $codeNew, 'your new email address')
            );
        } catch (\Exception $e) {
            error_log('Mail send failed: ' . $e->getMessage());
            echo json_encode(['ok' => false, 'error' => 'Failed to send confirmation email. Please try again.']);
            return;
        }

        Session::set('pending_new_email', $newEmail);
        echo json_encode(['ok' => true]);
    }

    public function verifyEmailChange(): void
    {
        $userId = $this->guard();
        header('Content-Type: application/json');

        $codeOld  = trim($_POST['code_old'] ?? '');
        $codeNew  = trim($_POST['code_new'] ?? '');
        $newEmail = Session::get('pending_new_email');

        if (!$newEmail) {
            echo json_encode(['ok' => false, 'error' => 'Session expired. Please start again.']);
            return;
        }

        $recordOld = VerificationCode::findValid($userId, $codeOld, 'email_change_old');
        if (!$recordOld) {
            echo json_encode(['ok' => false, 'error' => 'Invalid or expired code for current email.']);
            return;
        }

        $recordNew = VerificationCode::findValid($userId, $codeNew, 'email_change_new');
        if (!$recordNew) {
            echo json_encode(['ok' => false, 'error' => 'Invalid or expired code for new email.']);
            return;
        }

        VerificationCode::markUsed((int) $recordOld['id']);
        VerificationCode::markUsed((int) $recordNew['id']);
        User::updateEmail($userId, $newEmail);
        Session::remove('pending_new_email');

        echo json_encode(['ok' => true]);
    }

    public function updatePassword(): void
    {
        $userId = $this->guard();
        header('Content-Type: application/json');

        $currentPw = $_POST['current_password'] ?? '';
        $newPw     = $_POST['new_password'] ?? '';
        $confirmPw = $_POST['confirm_password'] ?? '';

        $db   = Database::getInstance();
        $stmt = $db->prepare('SELECT password FROM users WHERE id = ? LIMIT 1');
        $stmt->execute([$userId]);
        $row = $stmt->fetch();

        if (!$row || !password_verify($currentPw, $row['password'])) {
            echo json_encode(['ok' => false, 'error' => 'Current password is incorrect.']);
            return;
        }

        if (strlen($newPw) < 8) {
            echo json_encode(['ok' => false, 'error' => 'New password must be at least 8 characters.']);
            return;
        }

        if ($newPw !== $confirmPw) {
            echo json_encode(['ok' => false, 'error' => 'Passwords do not match.']);
            return;
        }

        User::updatePassword($userId, $newPw);
        echo json_encode(['ok' => true]);
    }

    private function buildEmailChangeCode(string $firstName, string $code, string $target): string
    {
        return '<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"></head>
        <body style="margin:0;padding:0;background:#f4f4f5;font-family:system-ui,sans-serif;">
            <table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 0;">
                <tr><td align="center">
                    <table width="480" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:10px;overflow:hidden;box-shadow:0 2px 12px rgba(0,0,0,.08);">
                        <tr><td style="background:#6366f1;padding:28px 40px;">
                            <p style="margin:0;font-size:22px;font-weight:700;color:#fff;">EduSync</p>
                        </td></tr>
                        <tr><td style="padding:36px 40px;">
                            <p style="margin:0 0 6px;font-size:13px;color:#6b7280;text-transform:uppercase;letter-spacing:.05em;font-weight:600;">Security</p>
                            <h1 style="margin:0 0 16px;font-size:22px;color:#111827;">Email change</h1>
                            <p style="margin:0 0 28px;font-size:15px;color:#4b5563;line-height:1.6;">Hello <strong>' . htmlspecialchars($firstName) . '</strong>, use the code below to confirm ' . $target . '.</p>
                            <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:28px;">
                                <tr><td align="center" style="background:#f4f4f5;border-radius:8px;padding:20px;">
                                    <p style="margin:0 0 6px;font-size:12px;color:#9ca3af;text-transform:uppercase;letter-spacing:.1em;">Your code</p>
                                    <p style="margin:0;font-size:36px;font-weight:700;letter-spacing:.25em;color:#6366f1;">' . htmlspecialchars($code) . '</p>
                                </td></tr>
                            </table>
                            <p style="margin:0;font-size:13px;color:#9ca3af;">This code expires in <strong>15 minutes</strong>.</p>
                        </td></tr>
                        <tr><td style="padding:20px 40px;border-top:1px solid #f3f4f6;">
                            <p style="margin:0;font-size:12px;color:#d1d5db;text-align:center;">© EduSync — Do not reply to this email.</p>
                        </td></tr>
                    </table>
                </td></tr>
            </table>
        </body></html>';
    }
}
