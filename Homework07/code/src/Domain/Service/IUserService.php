<?php

namespace Geekbrains\Application1\Domain\Service;

use Geekbrains\Application1\Domain\Models\User;

interface IUserService
{
    function createUser(string $name, string $lastname, string $birthday): User;
    function getAllUsersFromStorage(): bool|array;
    function findUserByUd(int $id) : User;
    function updateUser(User $user) : User;
    function deleteFromStorage(int $id) : bool;

}