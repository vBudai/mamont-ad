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
            header("Location: http://mamont-ad/auth");

        $this->view = new ProfileView();
    }

    // Вывод объявлений пользователя
    public function my_ads_Action($params = [])
    {
        $this->modelData = $this->model->getUserAds($this->id_user);
        $this->view->showAds("Мои объявления", $this->modelData);

    }

    // Удаления объявления
    public function deleteAd_action($params = [])
    {
        if(isset($params['id']))
            $this->model->deleteUserAd($params['id'], $_SESSION['id_user']);
    }

    // Вывод просмотренных объявлений
    public function watched_ads_Action($params = [])
    {
        $this->modelData = $this->model->getWatchedAds($this->id_user);
        $this->view->showAds("Просмотренные", $this->modelData);
    }

    // Удаление объявления из просмотренных
    public function deleteWatchedAds_action($params=[])
    {
        $this->model->deleteWatchedAd($params['id'], $this->id_user);
        header("Location: http://mamont-ad/profile/watched");
    }

    // Вывод списка диалогов
    public function messenger_Action($params = [])
    {
        $this->modelData = $this->model->getUserDialogs($this->id_user);
    }

    // Удаление диалога
    public function deleteDialog_Action($params = [])
    {
        $this->model->deleteUserDialog($params['id_dialog']);
    }

    // Вывод конкретного диалога
    public function dialog_Action($params = [])
    {
        if(isset($params['id']))
            $this->modelData = $this->model->getDialogMessages($params['id']);
    }

    // Вывод избранных объявлений
    public function favorites_Action($params = [])
    {
        $this->modelData = $this->model->getFavoritesAds($this->id_user);
        $this->view->showAds("Избранные", $this->modelData);
    }

    public function deleteFavoriteAd_Action($params = [])
    {
        $this->model->deleteFavoriteAd($params['id_ad'], $this->id_user);
        header("Location: http://mamont-ad/profile/favorites");
    }



    // Вывод архивных объявлений
    public function archive_Action($params = [])
    {
        $this->modelData = $this->model->getArchivedAds($this->id_user);
        $this->view->showAds("Архивированные", $this->modelData);
    }

    // Архивировать объявление
    public function archiveAd_Action($params = [])
    {
        if(isset($params['id']))
            $this->model->archiveAd($params['id'], $_SESSION['id_user']);
        header("Location: http://mamont-ad/profile");
    }

    // Удаление объявления из архивных
    public function unarchiveAd_Action($params)
    {
        if(isset($params['id']))
            $this->model->unarchiveAd($params['id'], $_SESSION['id_user']);
        header("Location: http://mamont-ad/profile/archive");
    }

    // Изменение настроек профиля
    public function settings_Action($params = [])
    {

        $this->view->showSettings();
    }

    public function setSettings_Action($params = [])
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

        header("Location: http://mamont-ad/profile/settings");
    }

    // Редактирование объявления
    public function editAd_Action($params = [])
    {
        // Пример параметров
        $changes = [
            'id_ad' => "12",
            'title'=>'aaa',
            'max_price' => '123456'
        ];
        $this->model->editAd($params['id_ad'], array_diff_key($params, ['id_ad']));
    }

    // Выход из профиля
    public function exit_Action($params = [])
    {
        if(isset($_SESSION['id_user']))
            unset($_SESSION['id_user']);

        header("Location: http://mamont-ad/auth");
    }


}