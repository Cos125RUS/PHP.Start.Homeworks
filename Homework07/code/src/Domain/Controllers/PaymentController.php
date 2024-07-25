<?php

namespace Geekbrains\Application1\Domain\Controllers;

use Exception;
use Geekbrains\Application1\Application\Render;
use Geekbrains\Application1\Domain\Models\Payment;
use Geekbrains\Application1\Domain\Models\User;
use Geekbrains\Application1\Domain\Service\UserService;

class PaymentController
{
    private string $prefix = 'payment/';
    private UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }


    public function actionIndex(): string
    {
        $render = new Render();

        $payments = Payment::getAllPayment();

        return $render->renderPage($this->prefix . 'payment-index.twig', [
            'title' => 'Страница платежей',
            'payments' => $payments
        ]);
    }

    /**
     * @throws Exception
     */
    public function actionFind(): string
    {
        $render = new Render();
        $id = key_exists('id', $_GET) && is_numeric($_GET['id']) ? (int)$_GET['id'] : 0;

        if (!$this->userService->findUserByUd($id)) throw new Exception("Пользователь не существует");
        $payments = Payment::getById($id);
        return $render->renderPage($this->prefix . 'payment-find.twig', [
            'title' => 'Страница платежей выбранного юзера',
            'payments' => $payments,
            'id' => $id
        ]);
    }
}