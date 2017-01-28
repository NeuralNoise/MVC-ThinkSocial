<?php
namespace App\Controllers;

use App\Models\User;
use App\Models\Comment;
use App\Models\NewsComment;

class CommentsController extends PageController
{
    public function actionAdd()
    {
        $user = User::checkLogged();
        $comments = new Comment();
        $comments->text = $_POST['dataForm'];
        $comments->userId = $user;
        $comments->insert();

        $idComment = $comments->id;

        $newsComment = new NewsComment();
        $newsComment->commentId = $idComment;
        $newsComment->newsId = $_POST['id'];
        $newsComment->insert();
    }

    public function actionGet()
    {
        $result = parent::actionIndex();
        $relationCommentNews = json_decode($_POST['id']);
        Comment::clearJoins();
        Comment::clearJoinsDB();
        Comment::joinDB('comments.id', 'news_comments', 'comment_id');
        Comment::joinDB('news_comments.news_id', 'news', 'id', [], false, ' AND news.id=:newsId');
        Comment::joinDB('comments.user_id', 'users', 'id', ['first_name' => 'firstName', 'last_name' => 'lastName']);
        Comment::joinDB('users.id', 'users_avatars', 'user_id', ['file_name' => 'fileName']);

        $comments = Comment::getByCondition(['status' => 'active', 'newsId' => $relationCommentNews],
                                             "ORDER BY created_at DESC");
        $result['comments'] = $comments;
        echo json_encode($result);
        exit;
    }

    public function actionDelete()
    {
        $idDeletedComment = json_decode($_POST['id']);
        Comment::setStatus($idDeletedComment,'delete');
    }
}
