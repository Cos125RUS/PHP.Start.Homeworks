<?php

require './vendor/autoload.php';

use Valerii\Homework04\task01\Library;
use Valerii\Homework04\task01\Book;
use Valerii\Homework04\task01\Closet;
use Valerii\Homework04\task01\Holder;

//Создаём библиотеку
$lib = new Library("Библиотека №12", "г.Владивосток, ул.Талалихина, д.10");
$closet = new Closet(8);
$lib->addCloset($closet);

//Создаём книгу
$book = new Book("Война и мир", "Лев Толстой", 1869, 1300);
$lib->addBook($book, $closet->getId(), 5);

//Создаём книгочея
$holder = new Holder("Иван", "+7(908)456-23-75");
$lib->addHolder($holder);

print_r($lib);

//Выдаём книгу читателю
$lib->giveBook($book, $holder);

echo PHP_EOL . "==================================" . PHP_EOL;
print_r($lib);
