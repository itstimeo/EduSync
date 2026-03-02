<?php

namespace EduSync\Controllers;

use EduSync\Core\Session;
use EduSync\Core\View;
use EduSync\Services\AuthService;

class AuthController
{
    public function showLogin(): void
    {
        View::render('auth/login', ['flash' => Session::getFlash()]);
    }

    public function login(): void
    {
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if ($email === '' || $password === '') {
            Session::flash('error', 'Email and password are required.');
            Session::redirect('/login');
        }

        $result = AuthService::login($email, $password);

        if (!$result['ok']) {
            Session::flash('error', $result['error']);
            Session::redirect('/login');
        }

        if ($result['trusted']) {
            Session::redirect('/dashboard');
        }

        Session::redirect('/verify-ip');
    }

    public function showRegister(): void
    {
        View::render('auth/register', ['flash' => Session::getFlash()]);
    }

    public function register(): void
    {
        $email     = trim($_POST['email'] ?? '');
        $password  = $_POST['password'] ?? '';
        $confirm   = $_POST['confirm'] ?? '';
        $firstName = trim($_POST['first_name'] ?? '');
        $lastName  = trim($_POST['last_name'] ?? '');

        if ($email === '' || $password === '' || $firstName === '' || $lastName === '') {
            Session::flash('error', 'All fields are required.');
            Session::redirect('/register');
        }

        if ($password !== $confirm) {
            Session::flash('error', 'Passwords do not match.');
            Session::redirect('/register');
        }

        $result = AuthService::register($email, $password, $firstName, $lastName);

        if (!$result['ok']) {
            Session::flash('error', $result['error']);
            Session::redirect('/register');
        }

        Session::redirect('/verify-email');
    }

    public function showVerifyEmail(): void
    {
        if (!Session::has('pending_verify_user_id')) {
            Session::redirect('/register');
        }

        View::render('auth/verify_email', ['flash' => Session::getFlash()]);
    }

    public function verifyEmail(): void
    {
        $userId = Session::get('pending_verify_user_id');

        if (!$userId) {
            Session::redirect('/register');
        }

        $code = trim($_POST['code'] ?? '');

        if ($code === '') {
            Session::flash('error', 'Verification code is required.');
            Session::redirect('/verify-email');
        }

        $result = AuthService::verifyEmailCode((int) $userId, $code);

        if (!$result['ok']) {
            Session::flash('error', $result['error']);
            Session::redirect('/verify-email');
        }

        Session::redirect('/dashboard');
    }

    public function showVerifyIp(): void
    {
        if (!Session::has('pending_user_id')) {
            Session::redirect('/login');
        }

        View::render('auth/verify_ip', ['flash' => Session::getFlash()]);
    }

    public function verifyIp(): void
    {
        $userId = Session::get('pending_user_id');

        if (!$userId) {
            Session::redirect('/login');
        }

        $code = trim($_POST['code'] ?? '');

        if ($code === '') {
            Session::flash('error', 'Verification code is required.');
            Session::redirect('/verify-ip');
        }

        $result = AuthService::verifyIpCode((int) $userId, $code);

        if (!$result['ok']) {
            Session::flash('error', $result['error']);
            Session::redirect('/verify-ip');
        }

        Session::redirect('/dashboard');
    }
}
