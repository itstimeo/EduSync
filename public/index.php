<?php

define('ROOT_PATH', dirname(__DIR__));

require_once ROOT_PATH . '/config/config.php';

use EduSync\Core\Router;
use EduSync\Core\Session;
use EduSync\Core\View;
use EduSync\Controllers\AuthController;
use EduSync\Controllers\DashboardController;
use EduSync\Services\AuthService;

Session::start();
AuthService::attemptRememberLogin();
View::setViewsPath(ROOT_PATH . '/src/Views');

$router = new Router();
$auth   = new AuthController();

$router->get('/login',     [$auth, 'showLogin']);
$router->post('/login',    [$auth, 'login']);
$router->get('/register',  [$auth, 'showRegister']);
$router->post('/register', [$auth, 'register']);
$router->get('/verify-email',  [$auth, 'showVerifyEmail']);
$router->post('/verify-email', [$auth, 'verifyEmail']);
$router->get('/verify-ip',     [$auth, 'showVerifyIp']);
$router->post('/verify-ip',    [$auth, 'verifyIp']);

$router->get('/logout', [$auth, 'logout']);

$dashboard = new DashboardController();
$router->get('/dashboard', [$dashboard, 'show']);

// Redirect root based on auth state
$router->get('/', function () {
    if (\EduSync\Core\Session::has('user_id')) {
        \EduSync\Core\Session::redirect('/dashboard');
    }
    \EduSync\Core\Session::redirect('/login');
});

$router->dispatch();
