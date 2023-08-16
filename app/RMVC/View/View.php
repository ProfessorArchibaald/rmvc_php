<?php

declare(strict_types=1);

namespace App\RMVC\View;

class View
{
    private static string $path;
    private static  ?array $data;

    public static function view(string $path, array $data = []): string
    {
        self::$data = $data;
        self::$path = str_replace('public', 'resources/views/', $_SERVER['DOCUMENT_ROOT']) .
            str_replace('.', '/', $path) . '.php';

        return self::getContent();
    }

    private static function getContent(): string
    {
        extract(self::$data);

        ob_start();
        include self::$path;
        $html = ob_get_contents();
        ob_end_clean();

        return $html;
    }
}