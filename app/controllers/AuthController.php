<?php

namespace app\controllers;

use app\core\BaseController;
use app\models\AuthModel;
use app\views\AuthView;

class AuthController extends BaseController
{

    public function __construct()
    {
        if(isset($_SESSION['id_user']))
            header("Location: " . BASE_URL . "profile");

        $this->model = new AuthModel();
        $this->view = new AuthView();
    }

    /**
     * Загрузка страницы входа и регистрации
     */
    public function form_Action($params = []) : void
    {
        $this->view->showForm();
    }


    /**
     * Обработка формы входа
     */
    public function login_Action($params = []) : void
    {

        // Парсинг данных с формы
        $params = [];
        $params += ['login' => $_POST['login']];
        $params += ['password' => $_POST['password']];

        $this->modelData = $this->model->login($params);

        if(is_string($this->modelData)){

            $_SESSION['form'] = "login";

            if($this->modelData === "Wrong login")
                $_SESSION['login_err'] = "Неправильный логин";
            else if($this->modelData === "Wrong password")
                $_SESSION['password_err'] = "Неправильный пароль";

            $_SESSION['login'] = $params['login'];



            header("Location: " . BASE_URL . "auth");
        }
        else if(is_int($this->modelData)){
            //session_start();
            $_SESSION['id_user'] = $this->modelData;
            header("Location: " . BASE_URL);
        }
    }

    /**
     * Обработка формы регистрации
     */
    public function registration_Action($params = []) : void
    {

        // Парсинг данных с формы
        $params = [];
        $params += ['login' => $_POST['login']];
        $params += ['password' => $_POST['password']];
        $params += ['email' => $_POST['email']];
        $params += ['phone_number' => $_POST['phone_number']];

        $this->modelData = $this->model->registration($params);
        if(is_array($this->modelData)){
            $_SESSION['form'] = "reg";

            $_SESSION['email'] = $params['email'];

            $_SESSION['phone_number'] = $params['phone_number'];

            $_SESSION['login'] = $params['login'];

            foreach ($this->modelData as $field)
                $_SESSION[$field . "Err"] = true;

            header("Location: " . BASE_URL . "auth");
        }
        else if (is_int($this->modelData)){
           $_SESSION['id_user'] = $this->modelData;
            header("Location: " . BASE_URL);
        }
        else{
            header("Location: " . BASE_URL . "auth");
        }

    }
}