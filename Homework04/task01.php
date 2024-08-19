<?php

require './vendor/autoload.php';

use Valerii\Homework04\task01\Library;
use Valerii\Homework04\task01\Book;
use Valerii\Homework04\task01\Closet;
use Valerii\Homework04\task01\Holder;
use Valerii\Homework04\task01\WebClient;
use Valerii\Homework04\task01\WebShop;
use Valerii\Homework04\task01\DigitalBook;

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

echo PHP_EOL . "================ После получения книги в библиотеке==================" . PHP_EOL;
print_r($lib);

echo PHP_EOL . "================= Создание интернет-магазина =================" . PHP_EOL;
//Создаём интернет-магазин
$shop = new WebShop("Books", "http://books.com", "123456789101112");

//Создаём электронную книгу
$digitBook = new DigitalBook("Мастер и Маргарита", "Михаил Булгаков", 1928, 512, 900);
$shop->addBook($digitBook);

//Создаём клиента интернет-магазина
$client = new WebClient("Фёдор", "fedor@mail.ru", "1111 2222 3333 4444");

print_r($shop);

echo PHP_EOL . "================= После продажи книги =================" . PHP_EOL;
$shop->trade($digitBook, $client);
print_r($shop);
print_r($client);