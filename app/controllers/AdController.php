<?php

namespace app\controllers;

use app\core\BaseController;
use app\models\AdModel;
use app\views\AdView;

class AdController extends BaseController
{
    public function __construct()
    {
        $this->model = new AdModel();
        $this->view = new AdView();
    }

    public function ad_Action($params = []): void
    {
        $this->modelData = $this->model->getAd($params['id']);
        if($this->modelData === []){
            (new ErrorController())->error(404);
            return;
        }
        if(isset($_SESSION['id_user'])){
            $this->model->addToWatched($params['id'], $_SESSION['id_user']);
            $this->modelData['isFavorite'] = $this->model->isFavoriteAd($_SESSION['id_user'], $params['id']);
        }
        else
            $this->modelData['isFavorite'] = false;
        $this->view->showAd($this->modelData);
    }
}