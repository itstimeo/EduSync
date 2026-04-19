<?php

namespace EduSync\Controllers;

use EduSync\Core\Session;
use EduSync\Models\GoogleToken;
use EduSync\Services\GoogleCalendarService;

class GoogleCalendarController
{
    public function connect(): void
    {
        $this->requireAuth();

        $state = bin2hex(random_bytes(16));
        Session::set('gcal_oauth_state', $state);

        header('Location: ' . GoogleCalendarService::getAuthUrl($state));
        exit;
    }

    public function callback(): void
    {
        $this->requireAuth();
        $userId = $this->userId();

        $state = trim($_GET['state'] ?? '');
        $code  = trim($_GET['code']  ?? '');

        if ($state === '' || $state !== Session::get('gcal_oauth_state')) {
            Session::flash('error', __('profile.gcal_oauth_invalid'));
            Session::redirect('/profile');
        }
        Session::remove('gcal_oauth_state');

        if (isset($_GET['error'])) {
            Session::flash('error', __('profile.gcal_access_denied'));
            Session::redirect('/profile');
        }

        if ($code === '') {
            Session::flash('error', __('profile.gcal_missing_code'));
            Session::redirect('/profile');
        }

        try {
            GoogleCalendarService::handleCallback($code, $userId);
            Session::flash('success', __('profile.gcal_connected'));
        } catch (\Throwable $e) {
            Session::flash('error', 'Could not connect Google Calendar: ' . $e->getMessage());
        }

        Session::redirect('/profile');
    }

    public function disconnect(): void
    {
        $this->requireAuth();
        $userId = $this->userId();

        GoogleToken::delete($userId);
        Session::flash('success', __('profile.gcal_disconnected'));
        Session::redirect('/profile');
    }

    private function requireAuth(): void
    {
        if (!Session::has('user_id')) {
            Session::redirect('/login');
        }
    }

    private function userId(): int
    {
        return (int) Session::get('user_id');
    }
}
