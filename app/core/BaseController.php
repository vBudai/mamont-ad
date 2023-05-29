<?php

namespace app\core;

abstract class BaseController
{
    public function model($model = '')
    {
        require_once "../models/" . $model . "Model.php";
        return new $model();
    }
}