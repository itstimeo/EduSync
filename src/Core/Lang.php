<?php

namespace EduSync\Core;

class Lang
{
    private static array $strings = [];
    private static string $lang = 'en';

    public static function init(string $lang): void
    {
        self::$lang = $lang;
        $file = ROOT_PATH . '/lang/' . $lang . '.php';
        if (!file_exists($file)) {
            $file = ROOT_PATH . '/lang/en.php';
        }
        self::$strings = require $file;
    }

    public static function current(): string
    {
        return self::$lang;
    }

    public static function get(string $key, array $params = []): string
    {
        $parts = explode('.', $key);
        $value = self::$strings;
        foreach ($parts as $part) {
            if (!is_array($value) || !array_key_exists($part, $value)) {
                return $key;
            }
            $value = $value[$part];
        }
        if (!is_string($value)) {
            return $key;
        }
        return !empty($params) ? vsprintf($value, $params) : $value;
    }

    public static function arr(string $key): array
    {
        $parts = explode('.', $key);
        $value = self::$strings;
        foreach ($parts as $part) {
            if (!is_array($value) || !array_key_exists($part, $value)) {
                return [];
            }
            $value = $value[$part];
        }
        return is_array($value) ? $value : [];
    }
}
