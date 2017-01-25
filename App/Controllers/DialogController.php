<?php
/**
 * Created by PhpStorm.
 * User: phpstudent
 * Date: 25.01.17
 * Time: 13:29
 */

namespace App\Controllers;

use App\Models\User;

class DialogController extends PageController
{
    public $templator;

    public function actionShow()
    {
        $this->templator = parent::actionIndex();
        $this->templator['templateNames'] = [
            'head',
            'navbar',
            'leftcolumn',
            'rightcolumn',
            'footer',
            ];
        $this->templator['title'] = 'Dialogs';

        return  $this->templator;
    }
}
