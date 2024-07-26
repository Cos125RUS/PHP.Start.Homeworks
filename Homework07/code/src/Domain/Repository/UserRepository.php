<?php

namespace Geekbrains\Application1\Domain\Repository;

use Exception;
use Geekbrains\Application1\Application\Application;
use Geekbrains\Application1\Domain\Models\User;
use PDO;
use PDOStatement;

/**
 * Класс для работы с таблицей Юзеров в базе данных
 */
class UserRepository implements IUserRepository
{
    /**
     * @var PDO База данных
     */
    public PDO $storage;

    public function __construct()
    {
        $this->storage = Application::$storage->get();
    }

    /** Извлечь всех юзеров
     * @return array|false
     */
    public function getAllUsers(): array|false
    {
        $sql = "SELECT * FROM users";

        $handler = $this->storage->query($sql);
        $this->setFetchModeToClass($handler);
        return $handler->fetchAll();
    }


    /**
     * Сохранение нового пользователя
     * @param User $user
     * @return User
     */
    public function save(User $user): User
    {
        $sql = 'INSERT INTO users (user_name, user_lastname, user_birthday_timestamp) 
    VALUE (:user_name, :user_lastname, :user_birthday_timestamp)';
        $params = [
            "user_name" => $user->getUserName(),
            "user_lastname" => $user->getUserLastname(),
            "user_birthday_timestamp" => $user->getUserBirthdayTimestamp()
        ];
        $this->executeQuery($sql, $params);
        $user->setIdUser($this->storage->lastInsertId());
        return $user;
    }

    /** Извлечение из БД по id
     * @param int $id
     * @return User|null
     */
    public function getById(int $id) : User|null
    {
        $sql = "SELECT * FROM users WHERE id_user = :id";
        $params = ["id" => $id];
        $handler = $this->executeQuery($sql, $params);
        $this->setFetchModeToClass($handler);
        return $handler->fetch();
    }

    /** Обновить данные пользователя
     * @param User $user
     * @return User
     * @throws Exception
     */
    public function update(User $user): User
    {
        $sql = 'UPDATE users 
        SET user_name = :name, 
            user_lastname = :lastname, 
            user_birthday_timestamp = :birthday 
        WHERE id_user = :id';
        $params = [
            "name" => $user->getUserName(),
            "lastname" => $user->getUserLastname(),
            "birthday" => $user->getUserBirthdayTimestamp(),
            "id" => $user->getIdUser()
        ];
        if ($this->executeQuery($sql, $params)) {
            return $user;
        } else {
            throw new Exception("Ошибка обновления пользователя в БД");
        }
    }

    /** Удаление юзера по id
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $sql = 'DELETE FROM users WHERE id_user = :id';
        $params = ["id" => $id];
        $this->executeQuery($sql, $params);
        return true;
    }

    /** Поиск по имени пользователя
     * @param string $login
     * @return User|null
     */
    function getByLogin(string $login): User|null
    {
        $sql = "SELECT id_user, user_name, user_lastname, password_hash FROM users WHERE login = :login";

        $handler = $this->executeQuery($sql);
        $this->setFetchModeToClass($handler);
        return $handler->fetch();
    }

    /** Выполнение запроса к БД
     * @param string $sql
     * @param array $params
     * @return bool|PDOStatement
     */
    private function executeQuery(string $sql, array $params = []): bool|PDOStatement
    {
        $handler = $this->storage->prepare($sql);
        $handler->execute($params);
        return $handler;
    }

    /** Установить метод извлечения данных на мапинг по классу User
     * @param PDOStatement $handler
     * @return void
     */
    private function setFetchModeToClass(PDOStatement $handler): void
    {
        $handler->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Geekbrains\Application1\Domain\Models\User');
    }

    /** Получить роль юзера по id
     * @param int $id
     * @return array|false
     */
    function getUserRoleById(int $id): array|false
    {
        $sql = "SELECT role FROM users WHERE id_user = :id";
        $handler = $this->executeQuery($sql, ["id" => $id]);
        return $handler->fetchAll();
    }
}