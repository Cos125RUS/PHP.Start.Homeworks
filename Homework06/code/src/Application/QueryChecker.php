<?php

namespace Geekbrains\Application1\Application;

class QueryChecker
{
    public static function checkId(): int
    {
        return key_exists('id', $_GET) && is_numeric($_GET['id']) ? (int)$_GET['id'] : 0;
    }

    public static function checkQuery(string $key): bool
    {
        return array_key_exists($key, $_GET);
    }
}