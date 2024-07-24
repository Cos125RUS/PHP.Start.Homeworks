<?php

namespace Geekbrains\Application1\Domain\Controllers;

use Geekbrains\Application1\Application\Application;
use Geekbrains\Application1\Application\Render;
use Geekbrains\Application1\Domain\Models\User;

class UserController
{
    private Render $render;
    private string $prefix = 'user/';

    public function __construct()
    {
        $this->render = new Render();
    }

    /**
     * Добавление пользователя через POST-запрос по форме
     * @return string
     */
    public function actionNew(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
            isset($_POST['name']) &&
            isset($_POST['lastname']) &&
            isset($_POST['birthday'])) {
            return $this->newUser($_POST['name'], $_POST['lastname'], $_POST['birthday']);
        } else {
            return "Ты как сюда попал?";
        }
    }

    /**
     * Добавление пользователя через аргументы url
     * @return string
     */
    public function actionSave(): string
    {
        if (!isset($_GET['name']) || !isset($_GET['birthday'])) {
            return $this->render->renderPage(
                "{$this->prefix}message.twig",
                [
                    'title' => "Некорректный ввод",
                    'message' => "Введено неправильное количество аргументов url-запроса"
                ]);
        }

        if (User::validateName($_GET['name']) && User::validateDate($_GET['birthday'])) {
            return $this->newUser($_GET['name'], $_GET['lastname'], $_GET['birthday']);
        } else {
            return $this->render->renderPage(
                $this->prefix . 'message.twig',
                [
                    'title' => "Некорректный ввод",
                    'message' => "Данные введены некорректно"
                ]);
        }
    }

    /**
     * Форма добавления пользователя
     * @return string
     */
    public function actionAdd(): string
    {
        return $this->render->renderPage(
            $this->prefix . 'user-add.twig',
            [
                'title' => 'Добавление пользователя',
            ]);
    }

    /**
     * Список пользователей
     * @return string
     */
    public function actionIndex(): string
    {
        $users = User::getAllUsersFromStorage();

        if (!$users) {
            return $this->render->renderPage(
                $this->prefix . 'user-empty.twig',
                [
                    'title' => 'Список пользователей в хранилище',
                    'message' => "Список пуст или не найден",
                    'href' => '/user/add'
                ]);
        } else {
            return $this->render->renderPage(
                $this->prefix . 'user-index.twig',
                [
                    'title' => 'Список пользователей в хранилище',
                    'users' => $users,
                    'href' => '/user/add'
                ]);
        }
    }

    /**
     * Вспомогательная функция добавления пользователя
     * @param string $name
     * @param string $lastname
     * @param string $birthday
     * @return string
     */
    private function newUser(string $name, string $lastname, string $birthday): string
    {
        $user = new User($name, $lastname, strtotime($birthday));
        if ($user->save()) {
            return $this->render->renderPage(
                'support/message.twig',
                [
                    'title' => "Пользователь добавлен",
                    'message' => "Пользователь $name $lastname добавлен"
                ]);
        } else {
            return $this->render->renderPage(
                'support/message.twig',
                [
                    'title' => "Ошибка записи",
                    'message' => "Ошибка записи. Пользователь $name $lastname не добавлен"
                ]);
        }
    }
}