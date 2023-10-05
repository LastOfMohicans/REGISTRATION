<?php 

namespace App\Controllers;

use App\Models\User;

class Registration extends Controller
{
    protected function handle()
    {
        session_start();
        header('Content-Type:text/html;charset=utf8');
        $user = new User();

        if (isset($_POST['reg'])) {
            $msg = $user->registration($_POST);

            if (true === $msg) {
                $_SESSION['msg'] = 'Вы успешно зарегистрировались на сайте. И для подтвержения регистрации  Вам на почту отправлено писмо с инструкциями.';
            } else {
                $_SESSION['msg'] = $msg;
            }
            header('Location: /?ctrl=registration');
            exit();
        }

        $this->view->display('registration');
    }
}