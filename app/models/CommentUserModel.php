<?php

namespace app\models;

use app\core\BaseModel;

class CommentUserModel extends BaseModel
{

    public function getUserComments($id_user): null|array
    {
        if($id_user < 0)
            return [];

        $sql = "SELECT id, id_creator, raiting, text FROM comment_user WHERE id_user = " . $id_user;

        return $data = $this->db->query($sql);
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

    public function createComment($id_user, $id_creator, $comment): void
    {
        // Создание комментария
        $sql = "INSERT INTO comment_user (id, id_user, id_creator, raiting, text) 
                VALUES (NULL, " . $id_user . ", " . $id_creator. ", " . $comment['comment_raiting'] . ", \"" . $comment['comment_text'] . "\")";
        $this->db->query($sql);
        $this->changeRaitingUser($id_user);
    }

    public function getCommentDataById($id_comment): array
    {
        $sql = "SELECT * FROM comment_user WHERE id=" . $id_comment;
        $data = $this->db->query($sql);
        if($data)
            return $data[0];
        return $data;
    }

    public function isExistComment($id_user, $id_creator): bool
    {
        $sql = "SELECT * FROM comment_user WHERE id_user=" . $id_user . " AND id_creator=" . $id_creator;
        if($this->db->query($sql))
            return true;
        return false;
    }

    public function editComment($id_comm, $id_user,$newData): void
    {
        $sql = "UPDATE comment_user SET raiting=" . $newData['comment_raiting'] . ", text='" . $newData['comment_text'] . "' WHERE id=" . $id_comm;
        $this->db->query($sql);

        $this->changeRaitingUser($id_user);
    }

    public function deleteComment($id_comm): void
    {
        $sql = "SELECT id_user FROM comment_user WHERE id=" . $id_comm;
        $id_user = $this->db->query($sql)[0]['id_user'];

        $sql = "DELETE FROM comment_user WHERE id=" . $id_comm;
        $this->db->query($sql);

        $this->changeRaitingUser($id_user);
    }


    private function changeRaitingUser($id_user): void
    {
        $sql = "SELECT AVG(raiting) as 'raiting' FROM comment_user WHERE id_user=".$id_user;
        $newRaiting = $this->db->query($sql)[0]['raiting'];

        if($newRaiting !== null)
            $sql = "UPDATE user SET raiting=" . $newRaiting . " WHERE id=" . $id_user;
        else
            $sql = "UPDATE user SET raiting=0 WHERE id=" . $id_user;
        $this->db->query($sql);
    }
}