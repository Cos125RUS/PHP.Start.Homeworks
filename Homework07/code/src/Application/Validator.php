<?php

namespace Geekbrains\Application1\Application;

use Exception;
use Geekbrains\Application1\Domain\Models\User;

class Validator
{
    public static function checkId(): int
    {
        return key_exists('id', $_GET) && is_numeric($_GET['id']) ? (int)$_GET['id'] : 0;
    }

    public static function checkQuery(string $key): bool
    {
        return array_key_exists($key, $_GET);
    }

    /** Проверка входящих данных на наличие скриптов
     * @param string $requestData
     * @return bool
     */
    public static function validateRequestData(string $requestData): bool
    {
        return preg_match('/<.*>/g', $requestData);
    }

}