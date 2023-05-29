<?php

namespace app\views;

class AuthView
{
    public function __construct(){}

    public function render($params = []) : void
    {
        require __DIR__ . "../../templates/auth.php";
    }
}