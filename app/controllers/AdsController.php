<?php

namespace app\controllers;

use app\models\AdsModel;
use app\views\AdsView;

class AdsController
{
    private AdsModel $model;

    private AdsView $view;
    private array|null $modelData;

    public function __construct()
    {
        $this->model = new AdsModel();
        $this->view = new AdsView();
    }

    public function ads_Action($params = []): void
    {
        /*if(!!$params & !empty($params)){
            foreach (array_reverse($params) as $param => $value){
                if($value != ""){
                    $this->modelData = $this->model->getAdsByCategories($param, $value);
                    break;
                }
            }
        }*/
        $page_title = "Все объявления";
        if(isset($params['main_category'])){
            $this->modelData = $this->model->getAdsByCategories('main_category', $params['main_category']);
            $page_title = $params['main_category'];
        }
        else
            $this->modelData = $this->model->getAdsByCategories();

        $this->addCitiesAndFavorites();

        $this->modelData['page_title'] = $page_title;

        $this->view->showAds($this->modelData);
    }


    public function searchAds_Action($params = []): void
    {
        if(!isset($_POST['title']))
            return ;

        $this->modelData = $this->model->searchByField("title", $_POST['title']);

        $this->addCitiesAndFavorites();

        $this->modelData['page_title'] = $_POST['title'];

        $this->view->showAds($this->modelData);
    }


    private function addCitiesAndFavorites(): void
    {
        if(isset($_SESSION['id_user'])){
            $favorites = $this->model->getFavoriteAds($_SESSION['id_user']);

            for($i = 0; $i < count($this->modelData); ++$i)
                if(in_array($this->modelData[$i]['id'], $favorites))
                    $this->modelData[$i]['isFavorite'] = true;
                else
                    $this->modelData[$i]['isFavorite'] = false;
        }
        $this->modelData['city'] = $this->model->getCitiesList();
    }

}