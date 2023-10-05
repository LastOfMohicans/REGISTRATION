<?php 

namespace App\Controllers;

use App\Models\User;

class Confirm extends Controller
{
    protected function handle()
    {
        session_start();
        header("Content-Type:text/html;charset=utf8");
        $user = new User();

        if ($_GET['hash']) {
            $confirm = $user->confirm();

            if (true === $confirm) {
                $confirm = 'Ваша учётная запись активирована!!!Можете авторизоваться на сайте!!!';
                $this->view->confirm = $confirm;
            } else {
                $error = 'Неверная ссылка!!!';
                $this->view->error = $error;
            }
        }        
        


        $this->view->display('confirm');
    }
}