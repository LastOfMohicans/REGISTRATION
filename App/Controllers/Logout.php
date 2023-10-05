<?php

namespace App\Controllers;

use App\Models\User;

class Logout extends Controller
{
       protected function handle() 
       {
            session_start();
            header('Content-Type:text/html;charset=utf8');
            $user = new User();
            if (isset($_POST['logout'])) {
            $msg = $user->logout();

            if (true === $msg) {
                $_SESSION['msg'] = 'Вы вышли из системы!!!';
                header('Location: /?ctrl=index');
                exit();
            }
        }

        
       }
}
