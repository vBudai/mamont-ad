<?php

namespace app\controllers;

use app\core\BaseController;
use app\models\ProfileModel;
use app\views\ProfileView;

class ProfileController extends BaseController
{
    private int $id_user;


    public function __construct()
    {
        if(isset($_SESSION['id_user']))
            $this->id_user = $_SESSION['id_user'];
        else
            header("Location: " . BASE_URL . "auth");

        $this->view = new ProfileView();
        $this->model = new ProfileModel();
    }


    /**
     * Вывод объявлений пользователя
     */
    public function userAds_Action($params = []): void
    {
        $this->modelData = $this->model->getUserAds($this->id_user);

        $userData = $this->model->getUserNameAndRaiting($this->id_user);
        $this->modelData['username'] = $userData['username'];
        $this->modelData['raiting'] = $userData['raiting'];
        $this->modelData['id_user'] = $this->id_user;

        $this->view->showAds("Мои объявления", $this->modelData);
    }


    /**
     * Удаление объявления пользователя
     */
    public function deleteAd_Action($params = []): void
    {
        if(isset($params['id']))
            $this->model->deleteUserAd($params['id'], $_SESSION['id_user']);

        header("Location: " . BASE_URL . "profile");
    }


    /**
     * Вывод просмотренных объявлений
     */
    public function watchedAds_Action($params = []): void
    {
        $this->modelData = $this->model->getWatchedAds($this->id_user);

        $userData = $this->model->getUserNameAndRaiting($this->id_user);
        $this->modelData['username'] = $userData['username'];
        $this->modelData['raiting'] = $userData['raiting'];
        $this->modelData['id_user'] = $this->id_user;

        $this->view->showAds("Просмотренные", $this->modelData);
    }


    /**
     * Удаление объявления из просмортренных
     */
    public function deleteWatchedAds_Action($params=[]): void
    {
        $this->model->deleteWatchedAd($params['id'], $this->id_user);
        header("Location: " . BASE_URL . "profile/watched");
    }


    /**
     * Вывод избранных объявлений
     */
    public function favorites_Action($params = []): void
    {
        $this->modelData = $this->model->getFavoritesAds($this->id_user);

        $userData = $this->model->getUserNameAndRaiting($this->id_user);
        $this->modelData['username'] = $userData['username'];
        $this->modelData['raiting'] = $userData['raiting'];
        $this->modelData['id_user'] = $this->id_user;

        $this->view->showAds("Избранные", $this->modelData);
    }


    /**
     * Удаление объявления из избранных
     */
    public function deleteFavoriteAd_Action($params = []): void
    {
        if(isset($params['id']))
            $this->model->deleteFavoriteAd($params['id'], $this->id_user);
        header("Location: " . BASE_URL . "profile/favorites");
    }


    /**
     * Добавление объявления в избранные
     */
    public function addFavoriteAd_Action($params = []): void
    {
        if(!isset($_SESSION['id_user']) || !isset($params['id']))
            return;

        $id_user = $_SESSION['id_user'];
        $id_ad = $params['id'];

        $this->model->addFavoriteAd($id_ad, $id_user);

        header("Location: " . BASE_URL . "profile/favorites");
    }


    /**
     * Вывод архивных объявлений
     */
    public function archive_Action($params = []): void
    {
        $this->modelData = $this->model->getArchivedAds($this->id_user);

        $userData = $this->model->getUserNameAndRaiting($this->id_user);
        $this->modelData['username'] = $userData['username'];
        $this->modelData['raiting'] = $userData['raiting'];
        $this->modelData['id_user'] = $this->id_user;

        $this->view->showAds("Архивированные", $this->modelData);
    }


    /**
     * Архивирование объявления
     */
    public function archiveAd_Action($params = []): void
    {
        if(isset($params['id']))
            $this->model->archiveAd($params['id'], $this->id_user);
        header("Location: " . BASE_URL . "profile");
    }


    /**
     * Разархивирование объявления
     */
    public function unarchiveAd_Action($params): void
    {
        if(isset($params['id']))
            $this->model->unarchiveAd($params['id'], $this->id_user);
        header("Location: " . BASE_URL . "profile/archive");
    }


    /**
     * Вывод формы настроек профиля
     */
    public function settings_Action($params = []): void
    {
        $userData = $this->model->getUserNameAndRaiting($this->id_user);
        $params['username'] = $userData['username'];
        $params['raiting'] = $userData['raiting'];
        $params['id_user'] = $this->id_user;
        $this->view->showSettings($params);
    }


    /**
     * Применение настроек профиля
     */
    public function setSettings_Action($params = []): void
    {

        $this->modelData = $this->model->setUserSettings($this->id_user, $_POST);

        if(is_array($this->modelData))
            foreach ($this->modelData as $field => $value){
                $_SESSION[$field] = $value;
            }

        header("Location: " . BASE_URL . "profile/settings");
    }


    /**
     * Выход из профиля
     */
    public function exit_Action($params = []): void
    {
        if(isset($_SESSION['id_user']))
            unset($_SESSION['id_user']);

        header("Location: " . BASE_URL . "auth");
    }


}