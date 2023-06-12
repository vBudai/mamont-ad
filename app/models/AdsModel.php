<?php

namespace app\models;

use app\core\BaseModel;

class AdsModel extends BaseModel
{
    public function getCitiesList() : array|null
    {
        $sql = "SELECT name FROM city";
        $cities = $this->db->query($sql);

        if(!$cities)
            return null;

        foreach ($cities as $index => $value){
            $cities[$index] = $value['name'];
        }

        return $cities;

    }

    public function getAdsByCategories($c_type = "", &$c_name = ""): array
    {
        if(!$this->is_russian($c_name))
            $this->to_cyrillic($c_name);
        if($c_type != "" && $c_name != "")
            $sql = "SELECT id, id_city, min_price, max_price, date, title FROM ad WHERE id_" . $c_type . "=(SELECT id FROM " . $c_type . " WHERE name='" . $c_name . "') AND is_archived=0";
        else
            $sql = "SELECT id, id_city, min_price, max_price, date, title FROM ad WHERE is_archived=0";

        $data = $this->db->query($sql);
        $this->transformationAdsData($data);
        return $data;
    }

    public function getFavoriteAds($id_user): array|null
    {
        $sql = "SELECT id_ad FROM favorite WHERE id_user=".$id_user;
        $data = $this->db->query($sql);

        foreach ($data as $index => $value){
            $data[$index] = $value['id_ad'];
        }

        if($data)
            return $data;

        return null;
    }

    public function searchByField($field, $value): array|null
    {
        $sql = "SELECT id, id_city, min_price, max_price, date, title FROM ad WHERE " . $field . " LIKE '%" . $value . "%'";
        $data = $this->db->query($sql);
        $this->transformationAdsData($data);
        if($data)
            return $data;

        return null;
    }

    private function to_cyrillic(&$string): void
    {
        $gost = array(
            "a"=>"а", "A"=>"А",
            "b"=>"б", "B"=>"Б",
            "v"=>"в", "V"=>"В",
            "g"=>"г", "G"=>"Г",
            "d"=>"д", "D"=>"Д",
            "e"=>"е", "E"=>"Е",
            "yo"=>"ё", "Yo"=>"Ё",
            "j"=>"ж", "J"=>"Ж",
            "z"=>"з", "Z"=>"З",
            "i"=>"и", "I"=>"И",
            "k"=>"к", "K"=>"К",
            "l"=>"л", "L"=>"Л",
            "m"=>"м", "M"=>"М",
            "n"=>"н",  "N"=>"Н",
            "o"=>"о", "O"=>"О",
            "p"=>"п", "P"=>"П",
            "r"=>"р", "R"=>"Р",
            "s"=>"с", "S"=>"С",
            "t"=>"т", "T"=>"Т",
            "y"=>"у", "Y" => "У",
            "f"=>"ф", "F"=>"Ф",
            "h"=>"х", "H"=>"Х",
            "c"=>"ц", "C"=>"Ц",
            "ch"=>"ч", "Ch"=>"Ч",
            "sh"=>"ш", "Sh"=>"Ш",
            "sh'"=>"щ", "Sh'"=>"Щ",
            "'" => 'ь',
            "i'" => "ы",
            "a'" => "э", "A'"  => "Э",
            "ya"=>"я", "Ya"=>"Я",
            "_" => " "
        );
        $string = strtr($string, $gost);
    }

    private function transformationAdsData( &$arr ): void
    {
        foreach ($arr as $key => $value){
            //$arr[$key] = $this->removeRepeatedInfo($value); // Удаление повторяющихся полей
            $arr[$key]['image_url'] = $this->getAdImage($value['id']); // Добавление изображения
            $arr[$key]['city'] = $this->getAdCity($value['id_city']); // Добавление города
        }
    }

    private function getAdImage($id): string|null
    {
        $sql = "SELECT image_url FROM image_ad WHERE id_ad=" . $id . ' LIMIT 1';
        $imageData = $this->db->query($sql);
        if($imageData)
            return $imageData[0]['image_url'];
        return null;
    }

    private function getAdCity($id) : string|null
    {
        $sql = "SELECT name FROM city WHERE id=" . $id;
        $city = $this->db->query($sql);
        if($city)
            return $city[0]['name'];
        return null;
    }

    private function removeRepeatedInfo($arr): array
    {
        foreach ($arr as $key => $value){
            if(is_numeric($key))
                unset($arr[$key]);
        }
        return $arr;
    }

    private function is_russian($text): bool
    {
        return preg_match('/[А-Яа-яЁё]/u', $text);
    }

}