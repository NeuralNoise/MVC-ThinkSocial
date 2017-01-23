<?php
namespace App\Controllers;

use App\Models\{
    Album, AlbumPhoto, User
};

class AlbumController extends PageController
{
    public function actionIndex($id)
    {
        $result = parent::actionIndex($id);
        $result['templateNames'] = [
            'head',
            'navbar',
            'leftcolumn',
            'middlecolumnalbum',
            'rightcolumn',
            'footer',
        ];
        $result['albumId'] = $id;
        return $result;
    }

    public function actionInsertPhoto($id)
    {
        $count = count($_FILES['uploadPhoto']['name']);
        $this->userId = User::checkLogged();
        if (!isset($_FILES['uploadPhoto'])) {
            throw new \Exception('Photo required');
        }
        for ($i = 0; $i < $count; $i++) {
            $this->fileValidation($i);
            $path = ROOT . '/public/photos/';
            $ext = explode('.', $_FILES['uploadPhoto']['name'][$i]);
            $newName = md5(time() . $ext[0]) . '.' . $ext[1];
            $full_path = $path . $newName;
            if (!move_uploaded_file($_FILES['uploadPhoto']['tmp_name'][$i], $full_path)) {
                header('Location: /album/' . $id);
            }
            $newPhoto = new AlbumPhoto();
            $newPhoto->fileName = $newName;
            $newPhoto->albumId = $id;
            $newPhoto->status = 'active';
            $newPhoto->insert();
            header('Location: /album/' . $id);
        }
    }

    public function actionDeletePhoto($id)
    {
        AlbumPhoto::delete($_GET['photoId']);
        header('Location: /album/view/' . $id);
    }
    
    public function actionUpdateAlbum($id)
    {
        $this->userId = User::checkLogged();
        $userAlbum = Album::getByID($id);
        $userAlbum->name = $_POST['newAlbumName'];
        $userAlbum->update();
        header('Location: /album/' . $id);
    }

    private function fileValidation($i)
    {
        $size = 1024 * 3 * 1024;//3 Mb
        $allowedExts = ['jpg', 'jpeg', 'gif', 'png'];
        $ext = explode('.', $_FILES['uploadPhoto']['name'][$i]);
        if ($_FILES['uploadPhoto']['size'][$i] > $size
            || $_FILES['uploadPhoto']['error'][$i] != 0
            || !in_array(end($ext), $allowedExts)
        ) {
            throw new \Exception('Size > 3 Mb OR some error occurred OR unsupported format');
        }
    }
}
