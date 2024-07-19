<?php

namespace Valerii\Homework04\task01;

/**
 * Книжный шкаф
 */
class Closet
{
    private array $shelfs;

    /**
     * @param array $shelfs
     */
    public function __construct(int $shelfCount)
    {
        $this->shelfs = [];
        for ($i = 0; $i < $shelfCount; $i++) {
            $this->shelfs[$i+1] = new Shelf();
        }
    }
}