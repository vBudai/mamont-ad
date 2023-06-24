<?php

namespace app\controllers;

use app\core\BaseController;
use app\models\CreateAdModel;
use app\views\CreateAdView;

class CreateAdController extends BaseController
{

    public function __construct()
    {
        if(!isset($_SESSION['id_user']))
            header("Location: " . BASE_URL . "auth");

        $this->model = new CreateAdModel();
        $this->view = new CreateAdView();
    }

    /**
     * Вывод формы создания объявления
     */
    public function form_Action($params = []): void
    {
        $this->view->showPage($this->model->getAllNames("main_category"), $this->model->getAllNames("city"));
    }

    /**
     * Обработка формы создания объявления
     */
    public function create_Action($params = []): void
    {
        $params = [];

        $params += [ "id_user" => $_SESSION['id_user'] ];
        $params += [ "date" => date('Y-m-d') ];

        foreach ($_POST as $field => $value){
            if($value === "")
                $value = NULL;
            $params += [$field => $value];
        }

        if(isset($_FILES['ad_photos'])){
            $images = $_FILES['ad_photos'];

            // Если пришло больше 5 фото
            if(count($images["name"]) >= 5)
                foreach ($images as $key => $values)
                    for($i = 5; $i < count($values); $i++)
                        unset($images[$key][$i]);

            $params += [ "images" => $images];
        }


        $id_ad = $this->model->createAd($params);

        header("Location: " . BASE_URL . "ad/" . $id_ad);

    }

    /**
     * Обработка формы для редактирования объявление (в поля добавляются данные объявления)
     */
    public function editForm_Action($params = []): void
    {

        if(isset($params['id'])){
            $this->modelData = $this->model->getAdInfo($params['id']);
            $this->modelData['id'] = $params['id'];
        }
        else{
            (new ErrorController())->error(404);
            return;
        }

        // Если объявление было создано пользователем, который пытается его редактировать
        if(!(isset($_SESSION['id_user']) && $_SESSION['id_user'] == $this->modelData['id_user'])){
            header("Location: " . BASE_URL);
            return ;
        }

        // Получение названия категории
        $this->modelData['category'] = $this->model->getNameById("main_category", $this->modelData['id_main_category']);
        unset($this->modelData['id_main_category']);

        // Получение названия города
        $this->modelData['city'] = $this->model->getNameById("city", $this->modelData['id_city']);
        unset($this->modelData['id_city']);



        $this->view->showPage($this->model->getAllNames("main_category"), $this->model->getAllNames("city"), $this->modelData);
    }


    /**
     * Обработка формы редактирования объявления
     */
    public function edit_Action($params = []): void
    {
        $id_ad = 0;
        if(isset($params['id'])){
            $id_ad = $params['id'];
            $this->modelData = $this->model->getAdInfo($id_ad);
        }
        else{
            (new ErrorController())->error(404);
            return;
        }

        // Если объявление не было создано пользователем, который пытается его редактировать
        if(!(isset($_SESSION['id_user']) && $_SESSION['id_user'] == $this->modelData['id_user'])){
            header("Location: " . BASE_URL);
            return ;
        }

        $params = [];
        $params += [ "date" => date('Y-m-d') ];

        foreach ($_POST as $field => $value){
            if($value === "")
                $value = NULL;
            $params += [$field => $value];
        }

        if($_FILES['ad_photos'] && count($_FILES['ad_photos']['name']) !== 1){
            $this->model->deleteAdImages($id_ad);

            $images = $_FILES['ad_photos'];

            // Если пришло больше 5 фото
            if(count($images["name"]) >= 5)
                foreach ($images as $key => $values)
                    for($i = 5; $i < count($values); $i++)
                        unset($images[$key][$i]);

            $params += [ "images" => $images];
        }

        $this->model->editAd($id_ad, $params);

        header("Location: " . BASE_URL . "ad/" . $id_ad);
    }

}