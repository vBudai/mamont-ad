<?php

namespace app\views;

class CommentUserView
{

    public function showCreateCommentForm($id_user, $data = []): void
    {
        require __DIR__ . "../../templates/comment_user_form.php";
    }

    public function showUserComments($data, $id_user = null): void
    {
        require __DIR__ . "../../templates/comments_user.php";
    }

}