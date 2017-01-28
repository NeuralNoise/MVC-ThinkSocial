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
        $news->insert();

        $newsId = $news->id;

        $userNews = new UserNews();
        $userNews->userId = $user;
        $userNews->newsId = $newsId;
        $userNews->insert();
    }

    public function actionGet()
    {
        $result = parent::actionIndex();
        News::clearJoins();
        News::clearJoinsDB();
        News::joinDB('news.id', 'users_news', 'news_id', [], false, ' AND users_news.user_id=:userId');
        if (isset($_POST['startFrom'])) {
            $news = News::getByCondition(['userId' => $this->userId, 'status' => 'active'],
                "ORDER BY created_at DESC LIMIT " . $_POST['startFrom'] . ", 4");
        } else {
            $news = News::getByCondition(['userId' => $this->userId, 'status' => 'active'], "ORDER BY created_at DESC LIMIT 4");
        }
        $result['news'] = $news;
        echo json_encode($result);
        exit;
    }

    public function actionDelete()
    {
        $idDeletedNews = json_decode($_POST['id']);
        News::setStatus($idDeletedNews, "delete");
    }
}
