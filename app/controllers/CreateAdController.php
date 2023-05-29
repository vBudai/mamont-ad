<?php

namespace app\controllers;

use app\models\CreateAdModel;
use app\views\CreateAdView;

class CreateAdController
{
    private CreateAdModel $model;
    private bool $modelData;
    private CreateAdView $view;


    public function __construct()
    {
        if(!isset($_SESSION['id_user']))
            header("Location: http://mamont-ad/auth");

        $this->model = new CreateAdModel();
        $this->view = new CreateAdView();
    }

    public function form_Action($params = []){
        $this->view->showPage();
    }

    public function create_Action($params = [])
    {

        $params = [];

        $params += [ "id_user" => $_SESSION['id_user'] ];
        $params += [ "date" => date('Y-m-d') ];

        foreach ($_POST as $field => $value){
            if($value === "")
                $value = NULL;
            $params += [$field => $value];
        }

        $images = $_FILES['ad_photos'];
        /*foreach ($_FILES['ad_photos'] as $index => $value){
            $images += [$index => $value];
        }*/

        $params += [ "images" => $images];

        $id_ad = $this->model->create_ad($params);

        $url = "Location http://mamont-ad/ad/" . $id_ad;

        header("Location http://mamont-ad");

    }


}