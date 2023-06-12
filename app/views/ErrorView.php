<?php

namespace app\views;

class ErrorView
{

    public function showError($err)
    {
        require __DIR__ . "../../templates/" . $err . ".php";
    }

}