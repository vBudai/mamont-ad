<?php

namespace app\controllers;

use app\models\ProfileModel;
use app\views\ProfileView;

class ProfileController
{
    private ProfileModel $model;

    private int $id_user;

    private array|bool $modelData;
    private ProfileView $view;


    public function __construct()
    {
        $this->model = new ProfileModel();
        if(isset($_SESSION['id_user']))
            $this->id_user = $_SESSION['id_user'];
        else
            header("Location: " . BASE_URL . "auth");

        $this->view = new ProfileView();
    }

    // Вывод объявлений пользователя
    public function my_ads_Action($params = []): void
    {
        $this->modelData = $this->model->getUserAds($this->id_user);
        $this->modelData['username'] = $this->model->getUserName($this->id_user);
        $this->view->showAds("Мои объявления", $this->modelData);
    }

    // Удаления объявления
    public function deleteAd_action($params = []): void
    {
        if(isset($params['id']))
            $this->model->deleteUserAd($params['id'], $_SESSION['id_user']);

        header("Location: " . BASE_URL . "profile");
    }

    // Вывод просмотренных объявлений
    public function watched_ads_Action($params = []): void
    {
        $this->modelData = $this->model->getWatchedAds($this->id_user);
        $this->modelData['username'] = $this->model->getUserName($this->id_user);
        $this->view->showAds("Просмотренные", $this->modelData);
    }

    // Удаление объявления из просмотренных
    public function deleteWatchedAds_action($params=[]): void
    {
        $this->model->deleteWatchedAd($params['id'], $this->id_user);
        header("Location: " . BASE_URL . "profile/watched");
    }

    // Вывод избранных объявлений
    public function favorites_Action($params = []): void
    {
        $this->modelData = $this->model->getFavoritesAds($this->id_user);
        $this->modelData['username'] = $this->model->getUserName($this->id_user);
        $this->view->showAds("Избранные", $this->modelData);
    }

    public function deleteFavoriteAd_Action($params = []): void
    {
        if(isset($params['id']))
            $this->model->deleteFavoriteAd($params['id'], $this->id_user);
        header("Location: " . BASE_URL . "profile/favorites");
    }

    public function addFavoriteAd_Action($params = []): void
    {
        if(!isset($_SESSION['id_user']) && !isset($params['id']))
            return;

        $id_user = $_SESSION['id_user'];
        $id_ad = $params['id'];

        $this->model->addFavoriteAd($id_ad, $id_user);

        header("Location: " . BASE_URL . "profile/favorites");
    }


    // Вывод архивных объявлений
    public function archive_Action($params = []): void
    {
        $this->modelData = $this->model->getArchivedAds($this->id_user);
        $this->modelData['username'] = $this->model->getUserName($this->id_user);
        $this->view->showAds("Архивированные", $this->modelData);
    }

    // Архивировать объявление
    public function archiveAd_Action($params = []): void
    {
        if(isset($params['id']))
            $this->model->archiveAd($params['id'], $_SESSION['id_user']);
        header("Location: " . BASE_URL . "profile");
    }

    // Удаление объявления из архивных
    public function unarchiveAd_Action($params): void
    {
        if(isset($params['id']))
            $this->model->unarchiveAd($params['id'], $_SESSION['id_user']);
        header("Location: " . BASE_URL . "profile/archive");
    }

    // Изменение настроек профиля
    public function settings_Action($params = []): void
    {
        $params['username'] = $this->model->getUserName($this->id_user);
        $this->view->showSettings($params);
    }

    public function setSettings_Action($params = []): void
    {

        $params = [];

        foreach ($_POST as $field => $value){
            $params += [$field => $value];
        }

        $this->modelData = $this->model->setUserSettings($this->id_user, $params);

        if(is_array($this->modelData))
            foreach ($this->modelData as $field => $value){
                $_SESSION[$field] = $value;
            }

        header("Location: " . BASE_URL . "profile/settings");
    }

    // Выход из профиля
    public function exit_Action($params = []): void
    {
        if(isset($_SESSION['id_user']))
            unset($_SESSION['id_user']);

        header("Location: " . BASE_URL . "auth");
    }


}