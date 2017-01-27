<?php

namespace App\Controllers;

use App\Components\AdminBase;

class AdminController extends PageController
{
    use AdminBase;

    public function actionIndex()
    {
        self::checkAdmin();
        return ['templateNames' => ['/admin/index']];
    }
}