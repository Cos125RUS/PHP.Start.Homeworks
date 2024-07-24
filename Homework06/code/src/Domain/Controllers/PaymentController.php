<?php

namespace Geekbrains\Application1\Domain\Controllers;

use Geekbrains\Application1\Application\Render;
use Geekbrains\Application1\Domain\Models\Payment;

class PaymentController
{
    private string $prefix = 'payment/';

    public function actionIndex(): string
    {
        $render = new Render();

        $payments = Payment::getAllPayment();

        return $render->renderPage($this->prefix . 'payment-index.twig', [
            'title' => 'Страница платежей',
            'payments' => $payments
        ]);
    }

    public function actionFind(): string
    {
        $render = new Render();
        $id = (int)$_GET['id'] ?? 0;

        $payments = Payment::getById();
        return $render->renderPage($this->prefix . 'payment-find.twig', [
            'title' => 'Страница платежей выбранного юзера',
            'payments' => $payments,
            'id' => $id
        ]);
    }
}