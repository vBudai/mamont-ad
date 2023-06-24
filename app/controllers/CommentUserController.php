<?php

namespace app\controllers;

use app\core\BaseController;
use app\models\CommentUserModel;
use app\views\CommentUserView;

class CommentUserController extends BaseController
{

    public function __construct()
    {
        $this->model = new CommentUserModel();
        $this->view = new CommentUserView();
    }

    public function userComment_Action($params = []): void
    {
        $idAuthUser = null;
        if(isset($_SESSION['id_user']))
            $idAuthUser = $_SESSION['id_user'];

        if(!isset($params['id_user'])){
            (new ErrorController())->error(404);
            return;
        }

        $id_user = $params['id_user'];

        $this->modelData = $this->model->getUserComments($id_user);
        $userData = $this->model->getUserNameAndRaiting($id_user);

        $this->modelData['username'] = $userData['username'];
        $this->modelData['raiting'] = $userData['raiting'];

        $this->view->showUserComments($this->modelData, $idAuthUser);
    }


    public function createComment_Action($params = []): void
    {
        $this->checkAllowedToCreate($params);

        if($_POST['comment_raiting'] > 5)
            $_POST['comment_raiting'] = 5;

        $this->model->createComment($params['id_user'], $_SESSION['id_user'], $_POST);

        header("Location: " . BASE_URL . "comment/user=" . $params['id_user']);
    }

    public function createCommentForm_Action($params = []): void
    {
        $this->checkAllowedToCreate($params);

        $this->view->showCreateCommentForm($params['id_user']);
    }

    public function editForm_Action($params = []): void
    {
        $this->checkAllowedToEdit($params);
        $this->view->showCreateCommentForm($this->modelData['id_user'], $this->modelData);
    }

    public function edit_Action($params = []): void
    {
        $this->checkAllowedToEdit($params);

        if($_POST['comment_raiting'] > 5)
            $_POST['comment_raiting'] = 5;

        $this->model->editComment($params['id_comment'], $this->modelData['id_user'], $_POST);

        header("Location: " . BASE_URL . "comment/user=" . $this->modelData['id_user']);
    }

    public function deleteComment_Action($params = []): void
    {
        $this->checkAllowedToEdit($params);
        $this->modelData = $this->model->getCommentDataById($params['id_comment']);
        $this->model->deleteComment($params['id_comment']);
        header("Location: " . BASE_URL . "comment/user=" . $this->modelData['id_user']);
    }


    private function checkAllowedToEdit($params = []): void
    {
        if(!isset($params['id_comment'])){
            (new ErrorController())->error(404);
            exit();
        }

        if(!isset($_SESSION['id_user'])){
            header("Location: " . BASE_URL . "auth");
            exit();
        }

        $this->modelData = $this->model->getCommentDataById($params['id_comment']);
        if($this->modelData['id_creator'] != $_SESSION['id_user']){
            header("Location: " . BASE_URL . "comment/user=" . $this->modelData['id_user']);
            exit();
        }
    }


    private function checkAllowedToCreate($params = []): void
    {
        if(!isset($_SESSION['id_user'])){
            header("Location: " . BASE_URL . "auth");
            exit();
        }

        if(!isset($params['id_user'])){
            (new ErrorController())->error(404);
            exit();
        }

        if($_SESSION['id_user'] == $params['id_user'] || $this->model->isExistComment($params['id_user'], $_SESSION['id_user'])){
            header("Location: " . BASE_URL . "comment/user=" . $params['id_user']);
            exit();
        }

    }
}