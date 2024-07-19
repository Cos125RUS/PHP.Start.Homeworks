<?php

namespace Valerii\Homework04\task01;

/**
 * Книга, хранимая в библиотеке
 */
class Book extends AbstractBook
{
    /**
     * @var Holder|null Клиент, взявший книгу в библиотеке
     */
    private Holder|null $holder;
    protected int $id;
    private static int $idCounter = 0;

    public function __construct(string $title, string $author, int $age, int $pageCount)
    {
        parent::__construct($title, $author, $age, $pageCount);
        $this->id = ++self::$idCounter;
    }

    /** Выдать книгу
     * @param Holder $holder
     * @return void
     */
    public function giveBook(Holder $holder): void
    {
        $this->holder = $holder;
        $holder->takeBook($this);
    }

    /** Вернуть книгу
     * @return void
     */
    public function comeBack(): void
    {
        $this->holder->returnBook($this->title);
        $this->holder = null;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }


}