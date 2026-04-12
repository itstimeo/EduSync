<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Application
define('APP_NAME', $_ENV['APP_NAME'] ?? 'EduSync');
define('APP_ENV', $_ENV['APP_ENV'] ?? 'production');
define('APP_URL', $_ENV['APP_URL'] ?? '');

// Database
define('DB_HOST', $_ENV['DB_HOST'] ?? 'localhost');
define('DB_PORT', (int) ($_ENV['DB_PORT'] ?? 3306));
define('DB_NAME', $_ENV['DB_NAME'] ?? 'edusync');
define('DB_USER', $_ENV['DB_USER'] ?? 'root');
define('DB_PASS', $_ENV['DB_PASS'] ?? '');

// Remember me
define('REMEMBER_INACTIVE_DAYS', (int) ($_ENV['REMEMBER_INACTIVE_DAYS'] ?? 14));
define('REMEMBER_MAX_DAYS',      (int) ($_ENV['REMEMBER_MAX_DAYS']      ?? 60));

// Mail
define('MAIL_HOST', $_ENV['MAIL_HOST'] ?? '');
define('MAIL_PORT', (int) ($_ENV['MAIL_PORT'] ?? 587));
define('MAIL_USERNAME', $_ENV['MAIL_USERNAME'] ?? '');
define('MAIL_PASSWORD', $_ENV['MAIL_PASSWORD'] ?? '');
define('MAIL_FROM_ADDRESS', $_ENV['MAIL_FROM_ADDRESS'] ?? '');
define('MAIL_FROM_NAME', $_ENV['MAIL_FROM_NAME'] ?? 'EduSync');
define('MAIL_ENCRYPTION', $_ENV['MAIL_ENCRYPTION'] ?? 'tls');

// Google Calendar
define('GOOGLE_CLIENT_ID',     $_ENV['GOOGLE_CLIENT_ID']     ?? '');
define('GOOGLE_CLIENT_SECRET', $_ENV['GOOGLE_CLIENT_SECRET'] ?? '');
define('GOOGLE_REDIRECT_URI',  $_ENV['GOOGLE_REDIRECT_URI']  ?? '');
