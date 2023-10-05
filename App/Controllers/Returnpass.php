<?php 

namespace App\Controllers;

use App\Models\User;

class Returnpass extends Controller
{
    protected function handle()
    {
        session_start();
        header("Content-Type:text/html;charset=utf8");
        $user = new User();

        if (isset($_POST['email'])) {
            $msg = $user->getPassword($_POST['email']);

            if (true === $msg) {
                $_SESSION['msg'] = 'Новый пароль выслан вам на почту!!!';
                header('Location: /?ctrl=login');
            } else {
                $_SESSION['msg'] = $msg;
                header('Location: /?ctrl=returnpass');
            }
            exit();
        }
        $this->view->display('returnpass');

    }
}