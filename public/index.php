<?php

define('ROOT_PATH', dirname(__DIR__));

require_once ROOT_PATH . '/config/config.php';

use EduSync\Core\Router;
use EduSync\Core\Session;
use EduSync\Core\View;
use EduSync\Controllers\AuthController;

Session::start();
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

// Placeholder dashboard
$router->get('/dashboard', function () {
    $name = \EduSync\Core\Session::get('user_name', 'User');
    http_response_code(200);
    echo '<h1>Welcome, ' . htmlspecialchars($name) . '!</h1><p>Dashboard — coming soon.</p>';
});

// Redirect root to login
$router->get('/', function () {
    \EduSync\Core\Session::redirect('/login');
});

$router->dispatch();
