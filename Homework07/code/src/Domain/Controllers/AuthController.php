<?php

namespace Geekbrains\Application1\Domain\Controllers;

use Geekbrains\Application1\Domain\Render\AuthRender;

class AuthController extends Controller
{
    private AuthRender $authRender;

    public function __construct()
    {
        parent::__construct();
        $this->authRender = new AuthRender();
    }

    /** Аутентификация
     * @return string
     */
    public function actionAuthentication(): string
    {
        $login = $_POST['login'];
        $password = $_POST['password'];
        header('location', '/');

        return $_POST['login'] . "   " . $_POST['password'];
    }

    /** Форма авторизации
     * @return string
     */
    public function actionLogin(): string
    {
        return $this->authRender->renderLogin("Вход", "Введите логин и пароль",
            "/auth/authentication", !empty($_SESSION['login']) ? $_SESSION['login'] : "");
    }

    /** Разлогирование
     * @return string
     */
    public function actionLogout(): string
    {
        return "Exit";
    }
}