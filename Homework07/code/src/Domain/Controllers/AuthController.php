<?php

namespace Geekbrains\Application1\Domain\Controllers;

use Exception;
use Geekbrains\Application1\Application\Application;
use Geekbrains\Application1\Domain\Render\AuthRender;
use Geekbrains\Application1\Domain\Render\IAuthRender;
use JetBrains\PhpStorm\NoReturn;

class AuthController extends Controller
{
    private IAuthRender $authRender;
    protected array $actionsPermissions = [
        'actionAuthentication' => ['user'],
        'actionLogin' => ['user'],
        'actionLogout' => ['user'],
    ];

    public function __construct()
    {
        parent::__construct();
        $this->authRender = new AuthRender();
    }

    /** Аутентификация
     * @return string
     * @throws Exception
     */
    #[NoReturn] public function actionAuthentication(): string
    {
        $user = $this->userService->authUser($_POST['login'], $_POST['password']);
        Application::$auth->setParams($user);

        if ($_POST['remember'] == 'on') {
            $token = hash("sha256", $user->getLogin());
            setcookie('token', $token, time() + 3600, '/');
            $user->setToken($token);
            $this->userService->updateUser($user);
        }

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
    #[NoReturn] public function actionLogout(): string
    {
        setcookie('token');
        session_destroy();
        header('Location: /', true, 303);
        exit();
    }
}