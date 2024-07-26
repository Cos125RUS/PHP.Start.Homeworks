<?php

namespace Geekbrains\Application1\Application;

use Geekbrains\Application1\Domain\Models\User;
use Geekbrains\Application1\Domain\Service\IUserService;
use Geekbrains\Application1\Domain\Service\UserService;

/**
 * Аутентификация
 */
class Auth
{
    private IUserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }


    /** Получить хэш пароля
     * @param string $rawPassword
     * @return string
     */
    public static function getPasswordHash(string $rawPassword): string {
        return password_hash($_GET['pass_string'], PASSWORD_BCRYPT);
    }

    public function proceedAuth(string $login, string $password): bool{
        $user = $this->userService->findUserByLogin($login);

        if(!$user && password_verify($password, $user->getHashPassword())){
            $_SESSION['user_name'] = $user->getUserName();
            $_SESSION['user_lastname'] = $user->getUserLastname();
            $_SESSION['id_user'] = $user->getIdUser();

            return true;
        }
        else {
            return false;
        }
    }

    /** Установить параметры сессии
     * @param User $user
     * @return void
     */
    public function setParams(User $user): void
    {
        $_SESSION['login'] = $user->getLogin();
        $_SESSION['password'] = $user->getHashPassword();
        $_SESSION['user_name'] = $user->getUserName();
        $_SESSION['user_lastname'] = $user->getUserLastname();
        $_SESSION['user_birthday_timestamp'] = $user->getUserBirthdayTimestamp();
        $_SESSION['id_user'] = $user->getIdUser();
        $_SESSION['roles'] = $user->getRoles();
    }
}