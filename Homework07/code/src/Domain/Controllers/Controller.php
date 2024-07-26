<?php

namespace Geekbrains\Application1\Domain\Controllers;

use Geekbrains\Application1\Application\Application;
use Geekbrains\Application1\Domain\Service\IUserService;
use Geekbrains\Application1\Domain\Service\UserService;

class Controller
{
    protected array $actionsPermissions = [];
    protected IUserService $userService;

    public function __construct()
    {

        $this->userService = new UserService();
    }

    public function getUserRoles(): array{
        $roles = [];
        $roles[] = 'user';

        if(isset($_SESSION['id_user'])){
            $userRoles = $this->userService->getUserRoleById((int)$_SESSION['id_user']);

            if($userRoles){
                foreach ($userRoles as $userRole) {
                    $roles[] = $userRole['role'];
                }
            }
        }

        return $roles;
    }

    public function getActionsPermissions(string $methodName): array {
        return $this->actionsPermissions[$methodName] ?? [];
    }
}