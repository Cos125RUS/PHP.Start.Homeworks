<?php

namespace Geekbrains\Application1\Domain\Render;

use Geekbrains\Application1\Application\Render;
use Geekbrains\Application1\Domain\Models\User;

class UserRender
{
    private string $prefix = 'user/';
    private Render $render;
    private array $usersList;

    public function __construct()
    {
        $this->render = new Render();
        $this->usersList = [
            "empty" => [
                "template" => "user-empty.twig",
                'message' => "Список пользователей пуст"
            ],
            "users" => [
                "template" => "user-index.twig",
                'message' => ""
            ]
        ];
    }

    /** Отображение формы добавления пользователей
     * @param string $title
     * @param string $subtitle
     * @param string $action
     * @param string $name
     * @param string $lastname
     * @param string|int $birthday
     * @return string
     */
    public function renderAddForm(string $title, string $subtitle, string $action, string $name = "",
                                  string $lastname = "", string|int $birthday = ""): string
    {
        return $this->render->renderPage($this->prefix . 'user-add.twig',
            [
                'title' => $title,
                'subtitle' => $subtitle,
                'action' => $action,
                'name' => $name,
                'lastname' => $lastname,
                'birthday' => $birthday,
            ]);
    }

    /** Универсальный шаблон отрисовки списка пользователей
     * @param string $mode модификатор списка (empty/users)
     * @param array $users
     * @return string
     */
    public function renderUsersList(string $mode, array $users = []): string
    {
        $data = $this->usersList[$mode];
        return $this->render->renderPage(
            $this->prefix . $data["template"],
            [
                'title' => "Список пользователей",
                'message' => $data["message"],
                'users' => $users,
                'href' => '/user/add'
            ]);
    }

//    /** Отображение пустого списка
//     * @return string
//     */
//    public function renderEmptyList(): string
//    {
//        return $this->render->renderPage($this->prefix . 'user-empty.twig',
//            [
//                'title' => 'Список пользователей в хранилище',
//                'message' => "Список пользователей пуст",
//                'href' => '/user/add'
//            ]);
//    }
//
//    public function renderUsersList(array $users): string
//    {
//        return $this->render->renderPage(
//            $this->prefix . 'user-index.twig',
//            [
//                'title' => 'Список пользователей в хранилище',
//                'users' => $users,
//                'href' => '/user/add'
//            ]);
//    }
}