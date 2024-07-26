<?php

namespace Geekbrains\Application1\Domain\Controllers;

use Geekbrains\Application1\Application\Render;

class PageController extends Controller
{

    public function actionIndex(): string
    {
        $render = new Render();

        return $render->renderPage('support/message.twig', [
            'title' => 'Главная страница',
            'message' => "Главная страница"
        ]);
    }
}