<?php

namespace app\controllers;

use app\models\AdsModel;
use app\views\AdsView;

class AdsController
{
    private AdsModel $model;

    private AdsView $view;
    private array $modelData;

    public function __construct()
    {
        $this->model = new AdsModel();
        $this->view = new AdsView();
    }

    public function ads_Action($params = []): void
    {
        if(!!$params & !empty($params)){
            foreach (array_reverse($params) as $param => $value){
                if($value != ""){
                    $this->modelData = $this->model->getAdsByCategories($param, $value);
                    break;
                }
            }
        }
        else{
            $this->modelData = $this->model->getAdsByCategories();
        }

        $this->view->showAds($this->modelData);
    }
}