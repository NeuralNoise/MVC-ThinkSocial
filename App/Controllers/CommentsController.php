<?php
namespace App\Controllers;

use App\Models\User;
use App\Models\Comment;

class CommentsController
{
    public function actionAdd()
    {
        $user = User::checkLogged();
        $comments = new Comment();
        $comments->text = $_POST['dataForm'];
        $comments->newsId = $_POST['id'];
        $comments->userId = $user;
        $comments->insert();
    }

    public function actionGet()
    {
        $relationCommentNews = json_decode($_POST['id']);
        Comment::clearJoins();
        Comment::clearJoinsDB();
        Comment::join('userId', 'App\Models\User', 'id');
        $comments = Comment::getByCondition(['deleted' => 0, 'newsId' => $relationCommentNews],
                                             "ORDER BY created_at DESC");

        echo json_encode($comments);
        exit;
    }

    public function actionDelete()
    {
        $idDeletedComment = json_decode($_POST['id']);
        Comment::deleteSoft($idDeletedComment);
    }
}
