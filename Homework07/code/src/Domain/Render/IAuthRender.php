<?php

namespace Geekbrains\Application1\Domain\Render;

interface IAuthRender
{
    function renderLogin(string $title, string $subtitle, string $action, string $login = ""): string;
}