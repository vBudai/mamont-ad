<?php

namespace app\controllers;

use app\models\AdModel;
use app\views\AdView;

class AdController
{

    private AdModel $model;
    private array $modelData;
    private AdView $view;

    public function __construct()
    {
        $this->model = new AdModel();
        $this->view = new AdView();
        $this->modelData = [];
    }

    public function ad_Action($params = []){
        $this->modelData = $this->model->getAd($params['id']);
        $this->view->showAd($this->modelData);

        if(isset($_SESSION['id_user'])){
            $this->model->addToWatched($params['id'], $_SESSION['id_user']);
        }
    }
}