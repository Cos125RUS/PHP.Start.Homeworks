<?php

namespace Valerii\Homework04\task01;

interface IBookTrader
{
    function trade(DigitalBook $book, WebClient $client);
}