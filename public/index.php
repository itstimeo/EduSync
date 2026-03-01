<?php

define('ROOT_PATH', dirname(__DIR__));

require_once ROOT_PATH . '/config/config.php';

// Routing and controllers will be implemented in subsequent branches
http_response_code(200);
echo '<h1>' . htmlspecialchars(APP_NAME) . '</h1>';
echo '<p>Application is running in <strong>' . htmlspecialchars(APP_ENV) . '</strong> mode.</p>';
