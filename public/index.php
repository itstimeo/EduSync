<?php

define('ROOT_PATH', dirname(__DIR__));

require_once ROOT_PATH . '/config/config.php';

use EduSync\Core\Router;
use EduSync\Core\Session;
use EduSync\Core\View;
use EduSync\Controllers\AuthController;
use EduSync\Controllers\CoursesController;
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

$courses = new CoursesController();

// Subjects
$router->get('/courses',        [$courses, 'showSubjects']);
$router->get('/courses/create', [$courses, 'showCreateSubject']);
$router->post('/courses/create',[$courses, 'createSubject']);
$router->get('/courses/edit',   [$courses, 'showEditSubject']);
$router->post('/courses/edit',  [$courses, 'updateSubject']);
$router->post('/courses/delete',[$courses, 'deleteSubject']);

// Themes
$router->get('/themes',         [$courses, 'showThemes']);
$router->get('/themes/create',  [$courses, 'showCreateTheme']);
$router->post('/themes/create', [$courses, 'createTheme']);
$router->get('/themes/edit',    [$courses, 'showEditTheme']);
$router->post('/themes/edit',   [$courses, 'updateTheme']);
$router->post('/themes/delete', [$courses, 'deleteTheme']);

// Chapters
$router->get('/chapters',          [$courses, 'showChapters']);
$router->get('/chapters/create',   [$courses, 'showCreateChapter']);
$router->post('/chapters/create',  [$courses, 'createChapter']);
$router->get('/chapters/edit',     [$courses, 'showEditChapter']);
$router->post('/chapters/edit',    [$courses, 'updateChapter']);
$router->post('/chapters/delete',  [$courses, 'deleteChapter']);

// Documents
$router->get('/documents',           [$courses, 'showDocuments']);
$router->get('/documents/upload',    [$courses, 'showUploadDocument']);
$router->post('/documents/upload',   [$courses, 'uploadDocument']);
$router->post('/documents/delete',   [$courses, 'deleteDocument']);
$router->get('/documents/download',  [$courses, 'downloadDocument']);
$router->get('/documents/serve',     [$courses, 'serveDocument']);
$router->get('/documents/view',      [$courses, 'viewDocument']);
$router->get('/documents/edit',      [$courses, 'showEditDocument']);
$router->post('/documents/edit',     [$courses, 'updateDocument']);

// Redirect root based on auth state
$router->get('/', function () {
    if (\EduSync\Core\Session::has('user_id')) {
        \EduSync\Core\Session::redirect('/dashboard');
    }
    \EduSync\Core\Session::redirect('/login');
});

$router->dispatch();
