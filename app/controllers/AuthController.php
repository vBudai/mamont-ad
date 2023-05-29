<?php

namespace app\controllers;

use app\models\AuthModel;
use app\views\AuthView;

class AuthController
{
    private AuthModel $model;

    private AuthView $view;

    private int|string|array $modelData;

    public function __construct()
    {
        if(isset($_SESSION['id_user']))
            header("Location: http://mamont-ad/profile");

        $this->model = new AuthModel();
        $this->view = new AuthView();
    }

    public function form_action($params = []) : void
    {
        $this->view->render();
    }

    public function login_Action($params = []) : void
    {

        // Парсинг данных с формы
        $params = [];
        foreach ($_POST as $param => $value)
            if($param === "login" || $param === "password")
                $params += [$param => $value];


        $this->modelData = $this->model->login($params);

        if(is_string($this->modelData)){

            $_SESSION['form'] = "login";

            if($this->modelData === "Wrong login")
                $_SESSION['login_err'] = "Неправильный логин";
            else if($this->modelData === "Wrong password")
                $_SESSION['password_err'] = "Неправильный пароль";

            $_SESSION['login'] = $params['login'];



            header("Location: http://mamont-ad/auth");
        }
        else if(is_int($this->modelData)){
            //session_start();
            $_SESSION['id_user'] = $this->modelData;
            header("Location: http://mamont-ad/");
        }
    }

    public function registration_Action($params = []) : void
    {
        // Примерчик массива
        /*$params = [
            'email' => 'email',
            'phone_number' => '79999',
            'login' => 'lalala',
            'password' => '123',
        ];*/
        // Парсинг данных с формы
        $params = [];
        foreach ($_POST as $param => $value)
            if($param === "login" || $param === "password" || $param === "email" || $param === "phone_number")
                $params += [$param => $value];

        $this->modelData = $this->model->registration($params);
        if(is_array($this->modelData)){
            $_SESSION['form'] = "reg";
            foreach ($this->modelData as $field){
                if($field === "email")
                    $_SESSION['email'] = $params['email'];
                if($field === "phone_number")
                    $_SESSION['phone_number'] = $params['phone_number'];
                if($field === "login")
                    $_SESSION['login'] = $params['login'];
            }

            header("Location: http://mamont-ad/auth");
        }
        else if (is_int($this->modelData)){
           $_SESSION['id_user'] = $this->modelData;
            header("Location: http://mamont-ad/");
        }

    }
}