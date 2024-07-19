<?php

namespace Valerii\Homework04\task01;

interface IBookBuyer
{
    function bay(DigitalBook $book, WebShop $shop);
}