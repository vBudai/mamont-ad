<?php

namespace app\models;

use app\core\BaseModel;

class AdsModel extends BaseModel
{
    public function getFilteredAds($params = [])
    {

    }

    public function getAdsByCategories($c_type = "", $c_name = ""): array
    {
        if(!$this->is_russian($c_name))
            $this->to_cyrillic($c_name);
        if($c_type != "" && $c_name != "")
            $sql = "SELECT id, min_price, max_price, date, title FROM ad WHERE id_" . $c_type . "=(SELECT id FROM " . $c_type . " WHERE name='" . $c_name . "') AND is_archived=0";
        else
            $sql = "SELECT id, min_price, max_price, date, title FROM ad WHERE is_archived=0";

        $data = $this->db->query($sql);
        $this->transformationAdsData($data);
        return $data;
    }

    private function to_cyrillic(&$string)
    {
        $gost = [
            "a" => "а", "b" => "б", "v" => "в", "g" => "г", "d" => "д", "e" => "е", "yo" => "ё",
            "j" => "ж", "z" => "з", "ii" => "и", "ji" => "й", "k" => "к",
            "l" => "л", "m" => "м", "n" => "н", "o" => "о", "p" => "п", "r" => "р", "s" => "с", "t" => "т",
            "y" => "у", "f" => "ф", "h" => "х", "c" => "ц",
            "ch" => "ч", "sh" => "ш", "sch" => "щ", "ie" => "ы", "u" => "у", "ya" => "я", "A" => "А", "B" => "Б",
            "V" => "В", "G" => "Г", "D" => "Д", "E" => "Е", "Yo" => "Ё", "J" => "Ж", "Z" => "З", "I" => "И", "Ji" => "Й",
            "K" => "К", "L" => "Л", "M" => "М",
            "N" => "Н", "O" => "О", "P" => "П",
            "R" => "Р", "S" => "С", "T" => "Т", "Y" => "Ю", "F" => "Ф", "H" => "Х", "C" => "Ц", "Ch" => "Ч", "Sh" => "Ш",
            "Sch" => "Щ", "Ie" => "Ы", "U" => "У", "Ya" => "Я", "'" => "ь", "_'" => "Ь", "''" => "ъ", "_''" => "Ъ",
            "yi" => "ї", "ge" => "ґ",
            "ye" => "є",
            "Yi" => "Ї",
            "II" => "І",
            "Ge" => "Ґ",
            "YE" => "Є",
        ];
        $string = strtr($string, $gost);
    }

    private function transformationAdsData( &$arr ): void
    {
        foreach ($arr as $key => $value){
            $arr[$key] = $this->removeRepeatedInfo($value); // Удаление повторяющихся полей
            $arr[$key]['image_url'] = $this->getAdImage($value['id']); // Добавление изображения
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