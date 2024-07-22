<?php

namespace Geekbrains\Application1\Controllers;

use Geekbrains\Application1\Application;
use Geekbrains\Application1\Render;
use Geekbrains\Application1\Models\User;

class UserController
{
    public function actionNew()
    {
        return "Сохранение пользователя через POST-запрос в разработке";
    }
    public function actionSave()
    {
        $args = [];
        $queryArray = explode('&', $_SERVER['QUERY_STRING']);
        foreach ($queryArray as $arg) {
            $res = explode('=', $arg);
            $args[$res[0]] = urldecode($res[1]);
        }

        $render = new Render();

        return $render->renderPage(
            'user-saved.twig',
            [
                'title' => "Пользователь добавлен",
                'name' => $args['name']
            ]);
    }

    public function actionAdd()
    {
        $render = new Render();

        return $render->renderPage(
            'user-add.twig',
            [
                'title' => 'Добавление пользователя',
            ]);
    }

    public function actionIndex()
    {
        $config = Application::config();
        $users = User::getAllUsersFromStorage($config['storage']['address']);

        $render = new Render();

        if (!$users) {
            return $render->renderPage(
                'user-empty.twig',
                [
                    'title' => 'Список пользователей в хранилище',
                    'message' => "Список пуст или не найден",
                    'href' => '/user/add'
                ]);
        } else {
            return $render->renderPage(
                'user-index.twig',
                [
                    'title' => 'Список пользователей в хранилище',
                    'users' => $users,
                    'href' => '/user/add'
                ]);
        }
    }
}