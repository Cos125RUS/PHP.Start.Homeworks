<?php

namespace Geekbrains\Application1\Domain\Render;

use Geekbrains\Application1\Application\Render;

class AuthRender implements IAuthRender
{
    private string $prefix = 'auth/';
    private Render $render;

    public function __construct()
    {
        $this->render = new Render();
    }

    /** Отрисовка страницы авторизации
     * @return string
     */
    public function renderLogin(string $title, string $subtitle, string $action, string $login = ""): string
    {
        return $this->render->renderPage($this->prefix . 'auth-login.twig',
        [
            'title' => $title,
            'subtitle' => $subtitle,
            'action' => $action,
            'login' => $login,
        ]);
    }
}