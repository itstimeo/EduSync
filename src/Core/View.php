<?php

namespace EduSync\Core;

class View
{
    private static string $viewsPath = '';

    public static function setViewsPath(string $path): void
    {
        self::$viewsPath = rtrim($path, '/\\');
    }

    public static function render(string $template, array $data = [], string $layout = 'layouts/base'): void
    {
        $templateFile = self::resolve($template);

        extract($data, EXTR_SKIP);

        ob_start();
        require $templateFile;
        $content = ob_get_clean();

        if ($layout !== '') {
            $layoutFile = self::resolve($layout);
            require $layoutFile;
        } else {
            echo $content;
        }
    }

    private static function resolve(string $template): string
    {
        $file = self::$viewsPath . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $template) . '.php';

        if (!file_exists($file)) {
            throw new \RuntimeException('View not found: ' . $template);
        }

        return $file;
    }
}
