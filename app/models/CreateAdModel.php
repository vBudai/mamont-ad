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
    public function getIdByName($table, $name): string|null
    {
        $sql = "SELECT id FROM " . $table . " WHERE name='" . $name . "'";
        $id_city = $this->db->query($sql);
        return $id_city[0]['id'];
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

        // Добавление изображений
        if(isset($images)){
            $id_ad = $this->db->lastInsertId("ad");
            $this->addImagesToAd($id_ad, $images);
        }

        return $id_ad;
    }

    // Добавление изображений в объявление
    private function addImagesToAd($id_ad, $images) : void
    {
        $sql = "INSERT INTO image_ad VALUES ";
        $values = "(NULL, " . $id_ad . "https://storage.yandexcloud.net/ads-images/YCAJE6qbvdLHnjCGxpxbO-BeC/no-photo.png)";

        if(!empty($images)){

            $values = "";

            for($i = 0; $i < count($images['name']); $i++){

                $picture_url = "https://storage.yandexcloud.net/ads-images/YCAJE6qbvdLHnjCGxpxbO-BeC/no-photo.png"; // Картинка "нет фото"


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

        // Переход на новое объявление
        //header("Location: ");
    }



}