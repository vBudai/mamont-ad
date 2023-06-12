<?php

namespace app\models;

use app\core\BaseModel;
use app\s3\Container;
use app\s3\S3ClientConfig;
use Aws\Exception\MultipartUploadException;
use Aws\S3\MultipartUploader;
use Aws\S3\S3Client;

use Aws\S3\Exception\S3Exception;

class CreateAdModel extends BaseModel
{
    public function getAllNames($table): array|null
    {
        $sql = "SELECT name FROM " . $table;

        $names = $this->db->query($sql);

        if($names){
            foreach ($names as $index => $value) // [0] => [name] => "..." в [0] => "..."
                $names[$index] = $value['name'];

            return $names;
        }

        return null;
    }

    public function getAdInfo($id_ad): array|null
    {
        $sql = "SELECT id_user, title, description, min_price, max_price, id_city, id_main_category FROM ad WHERE id=" . $id_ad;
        $ad = $this->db->query($sql);

        if($ad)
            return $ad[0];

        return null;
    }

    public function getIdByName($table, $name): string|null
    {
        $sql = "SELECT id FROM " . $table . " WHERE name='" . $name . "'";
        $id = $this->db->query($sql);
        return $id[0]['id'];
    }

    public function getNameById($table, $id): string|null
    {
        $sql = "SELECT name FROM " . $table . " WHERE id='" . $id . "'";
        $name = $this->db->query($sql);
        return $name[0]['name'];
    }

    public function create_ad($ad = []) : bool|string
    {
        if(isset($ad['images'])){
            $images = $ad['images']; // Вытаскивание переданных изображений
            unset($ad['images']);
        }

        $fields = "("; // Поля, в которые будут записываться значения
        $fieldValues = "VALUES ("; // Значения записываемых полей;
        foreach ($ad as $field => $value){

            if(str_starts_with($field, "id_") && $field !== "id_user"){
                $value = $this->getIdByName(substr($field, 3, null), $value);
            }

            $fields .= $field . ", ";
            if($value !== NULL)
                $fieldValues .= "'" . $value . "', ";
            else
                $fieldValues .= "NULL, ";
        }
        // Удаление последней запятой и пробелов в конце строки
        $fields = substr($fields, 0, -2) . ")";
        $fieldValues = substr($fieldValues, 0, -2) . ")";

        // Конечный запрос
        $sql = "INSERT INTO ad " . $fields . " " . $fieldValues;

        $this->db->query($sql);
        $id_ad = "";
        $id_ad = $this->db->lastInsertId("ad");
        // Добавление изображений
        if(isset($images)){
            $this->addImagesToAd($id_ad, $images);
        }

        return $id_ad;
    }

    public function editAd($id_ad, $newData): void
    {
        if(isset($newData['images'])){
            $images = $newData['images']; // Вытаскивание переданных изображений
            unset($newData['images']);
        }

        // UPDATE `ad` SET `title` = 'авыаываывавыаfdsasd', `description` = 'афывпыаврпырпыарыапврыеапврывапрывпdsaаfsdfsd', `min_price` = '123' WHERE `ad`.`id` = 107;
        $sql = "UPDATE ad SET ";

        foreach ($newData as $field => $value){
            if(str_starts_with($field, "id_") && $field !== "id_user")
                $value = $this->getIdByName(substr($field, 3, null), $value);


            if(($field === "min_price" || $field === "max_price") && $value == ''){
                $sql .= "`" . $field . "`=NULL, ";
            }
            else
                $sql .= "`" . $field . "`='" . $value . "', ";
        }

        $sql = substr($sql, 0, -2);
        $sql .= " WHERE id=" . $id_ad;

        $this->db->query($sql);

        // Добавление изображений
        if(isset($images))
            $this->addImagesToAd($id_ad, $images);
    }


    public function deleteAdImages($id_ad): void
    {
        // Удаление изображений
        $sql = "SELECT image_url FROM image_ad WHERE id_ad=" . $id_ad;
        $images = $this->db->query($sql);
        for($i = 0; $i < count($images); $i++)
            Container::getFileUploader()->delete($images[$i]['image_url']);


        $sql = "DELETE FROM image_ad where id_ad=" . $id_ad;
        $this->db->query($sql);
    }

    // Добавление изображений в объявление
    private function addImagesToAd($id_ad, $images) : void
    {
        $sql = "INSERT INTO image_ad VALUES ";
        $values = "(NULL, " . $id_ad . ", 'https://storage.yandexcloud.net/ads-images/no-photo.png')";

        if(!empty($images) && $images[0]['name'] !== ""){

            $values = "";

            for($i = 0; $i < count($images['name']); $i++){

                $picture_url = "https://storage.yandexcloud.net/ads-images/no-photo.png"; // Картинка "нет фото"


                if ($file = fopen($images['tmp_name'][$i], 'r+')){

                    //получение расширения
                    $ext = explode('.', $images["name"][$i]);
                    $ext = $ext[count($ext) - 1];
                    $filename = 'file' . rand(100000, 999999) . '.' . $ext;


                    $resource =  Container::getFileUploader()->store($file, $filename);
                    $picture_url = $resource['ObjectURL'];


                }

                $values .= "(NULL, " . $id_ad . ", \"" . $picture_url . "\"), ";

            }

            $values = substr($values, 0, -3) . ")";
        }

        $sql .= $values;

        $this->db->query($sql);
    }



}