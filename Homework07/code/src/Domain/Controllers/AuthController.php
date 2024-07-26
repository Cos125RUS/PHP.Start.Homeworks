<?php

namespace Geekbrains\Application1\Domain\Controllers;

use Exception;
use Geekbrains\Application1\Domain\Render\AuthRender;
use Geekbrains\Application1\Domain\Render\IAuthRender;
use Geekbrains\Application1\Domain\Render\ISupportRender;
use Geekbrains\Application1\Domain\Render\SupportRender;
use JetBrains\PhpStorm\NoReturn;

class AuthController extends Controller
{
    private IAuthRender $authRender;
    private ISupportRender $supportRender;

    public function __construct()
    {
        parent::__construct();
        $this->authRender = new AuthRender();
        $this->supportRender = new SupportRender();
    }

    /** Аутентификация
     * @return string
     * @throws Exception
     */
    #[NoReturn] public function actionAuthentication(): string
    {
        $user = $this->userService->authUser($_POST['login'], $_POST['password']);

        $_SESSION['login'] = $user->getLogin();
        $_SESSION['password'] = $user->getHashPassword();
        $_SESSION['user_name'] = $user->getUserName();
        $_SESSION['user_lastname'] = $user->getUserLastname();
        $_SESSION['user_birthday_timestamp'] = $user->getUserBirthdayTimestamp();
        $_SESSION['id_user'] = $user->getIdUser();

        header('Location: /', true, 303);
        exit();
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