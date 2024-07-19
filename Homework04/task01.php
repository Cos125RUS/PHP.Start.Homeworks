<?php

require './vendor/autoload.php';

use Valerii\Homework04\task01\Library;
use Valerii\Homework04\task01\Book;
use Valerii\Homework04\task01\Closet;

$lib = new Library("Библиотека №12", "г.Владивосток, ул.Талалихина, д.10");
$closet = new Closet(8);
$lib->addCloset($closet);
$book = new Book("Война и мир", "Лев Толстой", 1869, 1300);
$lib->addBook($book, $closet->getId(), 5);

print_r($lib);