<?php

namespace app\models;

use app\core\BaseModel;

class AdModel extends BaseModel
{
    public function getAd($id): array
    {
        $data = [];

        if($id > 0) {
            // Запрос на объявление
            $ad = $this->db->query("SELECT * FROM ad WHERE id=".$id);
            if($ad != null){
                $data = $ad[0];

                // Запрос на картинки
                $images = $this->db->query("SELECT * FROM image_ad WHERE id_ad=".$id);
                for($i=0; $i < count($images); $i++){
                    $data['images'][] = $images[$i]['image_url'];
                }

                // Запрос на кол-во просмотренных
                $watchedCount = $this->db->query("SELECT COUNT(id) as count FROM watched_ad WHERE id_ad=".$id);
                if($watchedCount != null)
                    $data['watchedCount'] = $watchedCount[0]['count'];

                // Запрос кол-во избранного
                $favoriteCount = $this->db->query("SELECT COUNT(id) as count FROM favorite WHERE id_ad=".$id);
                if($favoriteCount != null)
                    $data['favoriteCount'] = $favoriteCount[0]['count'];

                // Запрос на номер телефона пользователя, на имя и фамилию или логин
                $userData = $this->db->query("SELECT phone_number, login, first_name, last_name FROM user WHERE id=".$data['id_user']);
                if ($userData != null){
                    $data['phone_number'] = $userData[0]['phone_number'];
                    if($userData[0]['first_name'] !== "" && $userData[0]['last_name'] !== "")
                        $data['username'] = $userData[0]['first_name'] . " " . $userData[0]['last_name'];
                    else
                        $data['username'] = $userData[0]['login'];
                }

                // Запрос на название города
                $city = $this->db->query("SELECT name FROM city WHERE id=" . $data['id_city']);
                if($city != null){
                    $data['city'] = $city[0]['name'];
                    unset($data['id_city']);
                }

                // Запрос на категорию
                $category = $this->db->query("SELECT name FROM main_category WHERE id=" . $data['id_main_category']);
                if($category != null){
                    $data['main_category'] = $category[0]['name'];
                    unset($data['id_main_category']);
                }
            }
        }

        return $data;
    }


    public function isFavoriteAd($id_user, $id_ad): bool
    {
        $sql = "SELECT id FROM favorite WHERE id_ad=" . $id_ad . " AND id_user=" . $id_user;
        $data = $this->db->query($sql);

        return $data !== [];
    }


    public function addToWatched($id_ad, $id_user):void
    {
        // Проверка объявления на просмотренность
        $sql = "SELECT * FROM watched_ad WHERE " . "id_ad='" . $id_ad . "' AND id_user='" . $id_user . "'";
        $isWatched = $this->db->query($sql);

        // Добавление в просмотренные
        if($isWatched == null){
            $sql = "INSERT INTO watched_ad (id, id_ad, id_user) VALUES (NULL, '" . $id_ad . "', '" . $id_user . "')";
            $this->db->query($sql);
        }

    }


    private function removeRepeatedAdInfo( $arr ){
        foreach ($arr as $key => $value){
            if(is_numeric($key))
                unset($arr[$key]);
        }

        return $arr;
    }

}