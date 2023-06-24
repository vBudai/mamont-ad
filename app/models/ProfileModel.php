<?php

namespace app\models;

use app\controllers\ProfileController;
use app\core\BaseModel;
use app\s3\Container;

class ProfileModel extends BaseModel
{
    // Получение объявлений пользователя
    public function getUserAds($id_user = null): array|null
    {
        $data = [];

        if($id_user != null && $id_user > 0) {
            $sql = "SELECT id, min_price, max_price, date, title FROM ad WHERE id_user=" . $id_user . ' AND is_archived=0 ORDER BY id';
            $data = $this->db->query($sql);
            $this->getAdsImage($data);
        }

        return $data;
    }

    public function getUserNameAndRaiting($id_user): array
    {
        $sql = "SELECT login, first_name, last_name, raiting FROM user WHERE id=" . $id_user;
        $data = $this->db->query($sql)[0];
        if($data["first_name"] !== null && $data['last_name'] !== null)
            return ['username' => $data["first_name"] . " " . $data['last_name'], 'raiting' => $data['raiting']];
        else
            return ['username' => $data['login'], 'raiting' => $data['raiting']];
    }

    // Получение просмотренных объявлений
    public function getWatchedAds($id_user=null): array|null
    {
        $data = [];

        if($id_user != null && $id_user > 0) {
            $sql = "SELECT id_ad FROM watched_ad WHERE id_user=" . $id_user . ' ORDER BY id DESC';
            $id_ads = $this->db->query($sql);

            if($id_ads != null)
                $data = $this->getAdsById($id_ads, 0);
        }

        return $data;
    }

    // Получение избранных объявлений
    public function getFavoritesAds($id_user=null): array|null
    {
        $data = [];

        if($id_user != null && $id_user > 0) {
            $sql = "SELECT id_ad FROM favorite WHERE id_user=" . $id_user . ' ORDER BY id DESC';
            $id_ads = $this->db->query($sql);
            $data = $this->getAdsById($id_ads, 0);
        }

        return $data;
    }

    // Получение архивированных объявлений пользователя
    public function getArchivedAds($id_user=null): array|null
    {
        $data = [];

        if($id_user != null && $id_user > 0) {
            $sql = "SELECT id, min_price, max_price, date, title FROM ad WHERE is_archived=1 AND id_user=".$id_user;
            $data = $this->db->query($sql);
            $this->getAdsImage($data);
        }

        return $data;
    }

    // Архивирование объявления
    public function archiveAd($id_ad, $id_user): void
    {
        // Проверка, принадлежит ли объявление пользователю, который его удаляет
        $sql = "SELECT id_user FROM ad WHERE id_user=" . $id_user;
        $user = $this->db->query($sql);
        if($id_user != $user[0]['id_user'])
            return;

        $sql = "UPDATE ad SET is_archived=1 WHERE id=".$id_ad;
        $this->db->query($sql);
    }

    // Разархивирование объявления
    public function unarchiveAd($id_ad, $id_user): void
    {
        // Проверка, принадлежит ли объявление пользователю, который его удаляет
        $sql = "SELECT id_user FROM ad WHERE id_user=" . $id_user;
        $user = $this->db->query($sql);
        if($id_user != $user[0]['id_user'])
            return;

        $sql = "UPDATE ad SET is_archived=0 WHERE id=".$id_ad;
        $this->db->query($sql);
    }

    // Удаление объявления пользователя
    public function deleteUserAd($id_ad, $id_user): void
    {
        // Проверка, принадлежит ли объявление пользователю, который его удаляет
        $sql = "SELECT id_user FROM ad WHERE id_user=" . $id_user;
        $user = $this->db->query($sql);
        if($id_user != $user[0]['id_user'])
            return;

        // Удаление из просмотренных
        $sql = "DELETE FROM watched_ad WHERE id_ad=" . $id_ad;
        $this->db->query($sql);

        // Удаление из избранных
        $sql = "DELETE FROM favorite WHERE id_ad=" . $id_ad;
        $this->db->query($sql);

        // Удаление изображений
        $sql = "SELECT image_url FROM image_ad WHERE id_ad=" . $id_ad;
        $images = $this->db->query($sql);
        for($i = 0; $i < count($images); $i++)
            Container::getFileUploader()->delete($images[$i]['image_url']);

        $sql = "DELETE FROM image_ad where id_ad=" . $id_ad;
        $this->db->query($sql);

        // Удаление объявления
        $sql = "DELETE FROM ad WHERE id=" . $id_ad;
        $this->db->query($sql);
    }

    // Удаление объявления из просмотренных
    public function deleteWatchedAd($id_ad, $id_user): void
    {
        $sql = "DELETE FROM watched_ad WHERE id_ad=" . $id_ad . " AND id_user=" . $id_user;
        $this->db->query($sql);
    }

    // Удаление объявления из избранных
    public function deleteFavoriteAd($id_ad, $id_user): void
    {
        $sql = "DELETE FROM favorite WHERE id_ad=" . $id_ad . " AND id_user=" . $id_user;
        $this->db->query($sql);
    }

    public function addFavoriteAd($id_ad, $id_user): void
    {
        // Проверка, добавлено ли объявление уже в избранное
        $sql = "SELECT id FROM favorite WHERE id_ad=" . $id_ad . " AND id_user=".$id_user;
        if(!$this->db->query($sql)){
            $sql = "INSERT INTO favorite (id, id_ad, id_user) VALUES (NULL, " . $id_ad . ", " . $id_user . ")";
            $this->db->query($sql);
        }
    }

    // Применение настроек пользователя
    public function setUserSettings($id_user, $settings = []): bool|array
    {
        $usedFields = []; // Использованные поля

        $sql = "UPDATE user SET";

        // Добавление полей в запрос
        foreach ($settings as $setting => $value){
            if(!empty($setting) && $value != ""){
                if($setting == "password_md5")
                    $value = md5($value);
                if($setting == "password_md5" || $setting == "first_name" || $setting == "last_name" || $this->checkField($setting, $value))
                    $sql .= " " . $setting . "='" . $value . "',";
                else
                    $usedFields[$setting] = $value;
            }
        }
        $sql = substr($sql,0,-1); // Удаление последней запятой
        $sql .= " WHERE id=" . $id_user;

        $this->db->query($sql);

        if($usedFields == [])
            return true;
        else
            return $usedFields;
    }


    // Получение объявления по его id
    private function getAdsById($id_ads, $is_archived = 0): array|null
    {
        $ads = [];
        $ad = [];

        foreach ($id_ads as $key => $value){
            $sql = "SELECT id, min_price, max_price, date, title FROM ad WHERE id=" .$value['id_ad'] . " AND is_archived=" . $is_archived;
            //$sql = "SELECT id, min_price, max_price, date, title FROM ad WHERE id=93 AND is_archived=0";
            $ad = $this->db->query($sql);
            if($ad != null)
                $ads[] = $ad[0];
        }
        $this->getAdsImage($ads);
        return $ads;
    }

    // Проверка поля на повторение в таблице user
    private function checkField($field, $value): bool
    {
        $sql = "SELECT " . $field . " FROM user WHERE " . $field . "=" . "'" . $value . "'";
        if($this->db->query($sql) != null)
            return false;
        return true;
    }

    // Получение одной (певрой) фотографии для объявлений
    private function getAdsImage(&$arr): void
    {
        foreach ($arr as $key => $value){
            $sql = "SELECT image_url FROM image_ad WHERE id_ad=" . $value['id'] . ' LIMIT 1';
            $imageData = $this->db->query($sql);
            if($imageData)
                $arr[$key]['image_url'] = $imageData[0]['image_url'];
            else
                $arr[$key]['image_url'] = null;
        }
    }
}