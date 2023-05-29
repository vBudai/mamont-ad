<?php

namespace app\models;

use app\core\BaseModel;

class AuthModel extends BaseModel
{



    public function login($data = []): int|string
    {
        $sql = "SELECT id, password_md5 FROM user WHERE login='" . $data['login'] . "' OR email='" . $data['login'] . "' OR phone_number='" . $data['login'] . "'";
        if($userData = $this->db->query($sql)){
            if($userData[0]['password_md5'] == md5($data['password'])) {
                return $userData[0]['id'];
            }
            else
                return "Wrong password";
        }
        else
            return "Wrong login";
    }


    public function registration($userData = []): array|int
    {
        $usedFields = [];

        // Проверка занятости почты, номера и логина
        $emailCheck = "SELECT id from user WHERE email='" . $userData['email'] . "'";
        $phoneNumCheck = "SELECT id from user WHERE phone_number='" . $userData['phone_number'] . "'";
        $loginCheck = "SELECT id from user WHERE login='" . $userData['login'] . "'";
        if($this->db->query($emailCheck))
            $usedFields[] = 'email';
        if($this->db->query($phoneNumCheck))
            $usedFields[] = 'phone_number';
        if($this->db->query($loginCheck))
            $usedFields[] = 'login';

        if($usedFields === [] && $userData !== []) {
            $fields = "(";
            $fieldValues = "VALUES(";
            foreach ($userData as $field => $fieldValue) {
                if($field == "password"){
                    $fields .= 'password_md5' . ', ';
                    $fieldValues .= "'" . md5($fieldValue) . "', ";
                }
                else{
                    $fields .= $field . ', ';
                    $fieldValues .= "'" . $fieldValue . "', ";
                }
            }

            // Удаление последнего пробела и запятой
            $fields = substr($fields, 0, -2) . ")";
            $fieldValues = substr($fieldValues, 0, -2) . ")";
            $sql = "INSERT INTO user " . $fields . " " . $fieldValues;

                $this->db->query($sql);

            return $this->db->lastInsertId("user"); // Возвращение id нового пользователя
        }

        return $usedFields;
    }
}