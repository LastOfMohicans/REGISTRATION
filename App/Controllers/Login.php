<?php 

namespace App\Controllers;

use App\Models\User;

class Login extends Controller
{
    protected function handle()
    {
        session_start();
        header('Content-Type:text/html;charset=utf8');
        $user = new User();

        if (isset($_POST['login']) && isset($_POST['password'])) {
            $msg = $user->login($_POST);

            if (true === $msg) {
                header('Location: /?ctrl=admin');
            } else {
                $_SESSION['msg'] = $msg;
                header('Location: /?ctrl=login');
            }
            exit();
        }

        $this->view->display('login');
        
    }
    
}