<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\News;
use App\Models\UserNews;

class NewsController extends PageController
{
    public function actionAdd()
    {
        $user = User::checkLogged();
        $news = new News();
        $news->title = $_POST['title-news'];
        $news->text = $_POST['text-news'];
        $news->picture = "/img/img-post.jpg";
        $news->userId = $user;
        $news->insert();
    }

    public function actionGet()
    {
        if (isset($_POST['startFrom'])) {
            News::clearJoins();
            News::clearJoinsDB();
            News::join('userId', 'App\Models\User', 'id');
            $news = News::getByCondition(['deleted' => 0],
                                         "ORDER BY created_at DESC LIMIT " . $_POST['startFrom'] . ", 4");
        } else {
            News::clearJoins();
            News::clearJoinsDB();
            News::join('userId', 'App\Models\User', 'id');
            $news = News::getByCondition(['deleted' => 0], "ORDER BY created_at DESC LIMIT 4");
        }
        echo json_encode($news);
        exit;
    }

    public function actionDelete()
    {
        $idDeletedNews = json_decode($_POST['id']);
        News::deleteSoft($idDeletedNews);
    }
}
