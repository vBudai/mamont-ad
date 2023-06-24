<?php

namespace app\controllers;

use app\core\BaseController;
use app\views\ErrorView;

class ErrorController extends BaseController
{

    public function __construct()
    {
        $this->view = new ErrorView();
    }


    /**
     * Вывод страницы ошибки 404
     */
    public function error($err): void
    {
        $this->view->showError($err);
    }
}