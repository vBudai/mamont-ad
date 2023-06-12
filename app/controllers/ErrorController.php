<?php

namespace app\controllers;

use app\views\ErrorView;

class ErrorController
{

    private ErrorView $view;

    public function __construct()
    {
        $this->view = new ErrorView();
    }

    public function error($err): void
    {
        $this->view->showError($err);
    }
}