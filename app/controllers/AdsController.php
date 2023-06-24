<?php

namespace app\controllers;

use app\core\BaseController;
use app\models\AdsModel;
use app\views\AdsView;

class AdsController extends BaseController
{

    public function __construct()
    {
        $this->model = new AdsModel();
        $this->view = new AdsView();
        $this->modelData = [];
    }


    /**
     * Вывод объявлений по категориям (и без категорий)
     */
    public function ads_Action($params = []): void
    {
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



    /**
     * Обработка формы поиска в шапке сайта
     */
    public function searchAds_Action($params = []): void
    {
        if(!isset($_POST['title']))
            return ;

        $this->modelData = $this->model->searchByField("title", $_POST['title']);

        $this->addCitiesAndFavorites();

        $this->modelData['page_title'] = $_POST['title'];

        $this->view->showAds($this->modelData);
    }


    /**
     * Добавление избранных объявлений - для показа пользователю, какие объявления были добавлены в избранное
     * Добавление списка городов - для возможности фильтрации по городу
     */
    private function addCitiesAndFavorites(): void
    {
        if(isset($_SESSION['id_user'])){
            $favorites = $this->model->getFavoriteAds($_SESSION['id_user']);

            for($i = 0; $i < count($this->modelData); ++$i)
                if($favorites !== null && in_array($this->modelData[$i]['id'], $favorites))
                    $this->modelData[$i]['isFavorite'] = true;
                else
                    $this->modelData[$i]['isFavorite'] = false;
        }
        $this->modelData['city'] = $this->model->getCitiesList();
    }

}