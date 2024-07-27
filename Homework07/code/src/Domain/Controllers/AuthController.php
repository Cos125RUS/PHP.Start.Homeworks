<?php

namespace Geekbrains\Application1\Domain\Controllers;

use Exception;
use Geekbrains\Application1\Application\Application;
use Geekbrains\Application1\Application\Validator;
use Geekbrains\Application1\Domain\Models\User;
use Geekbrains\Application1\Domain\Render\AuthRender;
use Geekbrains\Application1\Domain\Render\IAuthRender;
use Geekbrains\Application1\Domain\Render\ISupportRender;
use Geekbrains\Application1\Domain\Render\SupportRender;
use JetBrains\PhpStorm\NoReturn;

class AuthController extends Controller
{
    private IAuthRender $authRender;
    private ISupportRender $supportRender;
    protected array $actionsPermissions = [
        'actionAuthentication' => ['user'],
        'actionLogin' => ['user'],
        'actionLogout' => ['user'],
        'actionRegistration' => ['user'],
        'actionCreation' => ['user'],
    ];

    public function __construct()
    {
        parent::__construct();
        $this->authRender = new AuthRender();
        $this->supportRender = new SupportRender();
    }

    /** Аутентификация
     * @throws Exception
     */
    #[NoReturn] public function actionAuthentication(): void
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
        return $this->authRender->renderAuthForm("auth", "Вход", "Введите логин и пароль",
            "/auth/authentication", !empty($_SESSION['login']) ? $_SESSION['login'] : "");
    }

    /** Форма регистрации
     * @return string
     */
    public function actionRegistration(): string
    {
        return $this->authRender->renderAuthForm("reg", "Вход", "Введите логин и пароль", "/auth/creation");
    }

    /** Создание нового пользователя
     * @return string
     * @throws Exception
     */
    #[NoReturn] public function actionCreation(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && Validator::checkCreateUserCountParams()) {
            if (Validator::checkConfirmPassword()) {
                if (User::validateLogin($_POST['login']) &&
                    User::validatePassword($_POST['password']) &&
                    User::validateName($_POST['name']) &&
                    User::validateName($_POST['lastname'])) {

                    $user = $this->userService->createUser($_POST['name'], $_POST['lastname'],
                        $_POST['birthday'], $_POST['login'], $_POST['password']);

                    Application::$auth->setParams($user);

                    header('Location: /', true, 303);
                    exit();
                } else {
                    return $this->supportRender->printMessage("Некорректный ввод",
                        "Введены некорректные данные");
                }
            } else {
                return $this->supportRender->printMessage("Некорректный ввод",
                    "Поля 'Пароль' и 'Подтверждение' не совпадают");
            }
        } else {
            return "Ты как сюда попал?";
        }
    }

    /** Разлогирование
     */
    #[NoReturn] public function actionLogout(): void
    {
        setcookie('token', '', time() - 3600, '/');
        session_destroy();
        header('Location: /', true, 303);
        exit();
    }
}