<?php

namespace Geekbrains\Application1\Domain\Service;

use Exception;
use Geekbrains\Application1\Domain\Models\User;
use Geekbrains\Application1\Domain\Repository\UserRepository;

class UserService
{
    private UserRepository $userRepository;

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
    public function findUserByUd(int $id) : User
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
}