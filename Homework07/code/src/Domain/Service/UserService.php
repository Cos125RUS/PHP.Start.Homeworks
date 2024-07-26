<?php

namespace Geekbrains\Application1\Domain\Service;

use Exception;
use Geekbrains\Application1\Domain\Models\User;
use Geekbrains\Application1\Domain\Repository\IUserRepository;
use Geekbrains\Application1\Domain\Repository\UserRepository;

class UserService implements IUserService
{
    private IUserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    /** Создание нового пользователя
     * @throws Exception
     */
    public function createUser(string $name, string $lastname, string $birthday): User
    {
        try {
            $user = new User($name, $lastname, strtotime($birthday));
            return $this->userRepository->save($user);
        } catch (Exception $e) {
            throw new Exception("Ошибка записи. Пользователь $name $lastname не добавлен");
        }
    }

    /** Извлечь всех юзеров из БД
     * @return array|false
     */
    public function getAllUsersFromStorage(): bool|array
    {
        return $this->userRepository->getAllUsers();
    }

    /** Поиск пользователя в БД по id
     * @param int $id
     * @return User
     * @throws Exception
     */
    public function findUserById(int $id) : User
    {
        $user = $this->userRepository->getById($id);
        if ($user) {
            return $user;
        } else {
            throw new Exception("Пользователь не найден");
        }
    }

    /** Обновление данных пользователя в БД
     * @throws Exception
     */
    public function updateUser(User $user) : User
    {
        return $this->userRepository->update($user);
    }

    /** Удаление пользователя из БД
     * @param int $id
     * @return bool
     */
    public function deleteFromStorage(int $id) : bool
    {
        return $this->userRepository->delete($id);
    }

    /** Поиск пользователя по логину
     * @param string $login
     * @return User
     */
    function findUserByLogin(string $login): User
    {
        return $this->userRepository->getByLogin($login);
    }

    /** Получить из БД роль юзера по его id
     * @param int $id
     * @return array|false
     */
    function getUserRoleById(int $id): array|false
    {
        return $this->userRepository->getUserRoleById($id);
    }

    /** Авторизация пользователя
     * @param string $login
     * @param string $password
     * @return User|false
     * @throws Exception
     */
    function authUser(string $login, string $password): User|false
    {
        $user = $this->findUserByLogin($login);
        $hash = $user->getHashPassword();
        if (password_verify($password, $hash)) {
            return $user;
        } else {
            throw new Exception("Пароль указан неверно");
        }
    }
}