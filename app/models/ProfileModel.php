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
            $sql = "SELECT id, min_price, max_price, date, title FROM ad WHERE id_user=" . $id_user . ' AND is_archived=0 ORDER BY id' ;
            $data = $this->db->query($sql);
            $this->transformationAdsData($data);
        }
        return $data;
    }

    // Получение просмотренных объявлений
    public function getWatchedAds($id_user=null): array|null
    {
        $data = [];
        if($id_user != null && $id_user > 0) {
            $sql = "SELECT id_ad FROM watched_ad WHERE id_user=" . $id_user . ' ORDER BY id DESC';
            $id_ads = $this->db->query($sql);
            $data += $this->getAdsById($id_ads);
        }
        return $data;
    }

    // Получение избранных объявлений
    public function getFavoritesAds($id_user=null): array|null
    {
        $data = [];
        if($id_user != null && $id_user > 0) {
            $sql = "SELECT id_ad FROM favorite WHERE id_user=" . $id_user . ' AND is_archived=0 ORDER BY id DESC';
            $id_ads = $this->db->query($sql);
            $data = $this->getAdsById($id_ads);
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
            $this->transformationAdsData($data);
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

    // Редактирование объявления
    public function editAd($id_ad, $changes = []): void
    {
        // UPDATE `ad` SET title='Toyota Wish, 2013', max_price='1249000' WHERE id=1;
        if($changes != []){
            $sql = "UPDATE ad SET ";
            foreach ($changes as $field => $newValue)
                if(!empty($field))
                    $sql .= $field . "='" . $newValue . "', ";

            $sql = substr($sql, 0, -2); //Удаление последнего пробела и запятой
            $sql .= " WHERE id=" . $id_ad;
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

        if($usedFields == [] && $this->db->query($sql))
            return true;
        else
            return $usedFields;
    }

    // Получение диалогов пользователя
    public function getUserDialogs($id_user): array
    {
        $sql = "SELECT id, id_ad FROM dialog WHERE id_seller=" . $id_user . " OR id_client=" . $id_user ;
        $dialogs = $this->db->query($sql);
        for($i=0; $i<count($dialogs); $i++)
            $dialogs[$i] = $this->removeRepeatedInfo($dialogs[$i]);
        return $dialogs;
    }

    // Удаление диалога
    public function deleteUserDialog($id_dialog): void
    {
        $sql = "DELETE FROM dialog WHERE id=" . $id_dialog;
        $this->db->query($sql);
    }

    // Получение сообщений диалога
    public function getDialogMessages($id_dialog): array
    {
        $sql = "SELECT * FROM message WHERE id_dialog=" . $id_dialog;
        $messages = $this->db->query($sql);
        for($i=0; $i<count($messages); $i++)
            $messages[$i] = $this->removeRepeatedInfo($messages[$i]);
        return $messages;
    }

    // Получение объявления по его id
    private function getAdsById($id_ads): array|null
    {
        $ads = [];
        foreach ($id_ads as $key => $value){
            $sql = "SELECT id, min_price, max_price, date, title FROM ad WHERE id=" .$value['id_ad'];
            $ad = $this->db->query($sql);
            $ads[] = $ad[0];
        }
        $this->transformationAdsData($ads);
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

    // Удаление повторяющейся информации и добавление изображения
    private function transformationAdsData( &$arr ): void
    {
        foreach ($arr as $key => $value){
            $arr[$key] = $this->removeRepeatedInfo($value); // Удаление повторяющихся полей
            $arr[$key]['image_url'] = $this->getAdImage($value['id']); // Добавление изображения
        }
    }

    // Получение одной (певрой) фотографии для объявления
    private function getAdImage($id_ad): string|null
    {
        $sql = "SELECT image_url FROM image_ad WHERE id_ad=" . $id_ad . ' LIMIT 1';
        $imageData = $this->db->query($sql);
        if($imageData)
            return $imageData[0]['image_url'];
        return null;
    }

    // Удаление повторяющейся информации (с индексами из целых чисел)
    private function removeRepeatedInfo($arr): array
    {
        foreach ($arr as $key => $value){
            if(is_numeric($key))
                unset($arr[$key]);
        }
        return $arr;
    }
}