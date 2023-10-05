<?php 

namespace App\Controllers;

use App\Models\User;

class Admin extends Controller
{
    protected function handle()
    {
        session_start();
        header("Content-Type:text/html;charset=utf8");
        $user = new User();

        if (!$user->checkUser()) {
            header('Location: /?ctrl=login');
        }

        $this->view->display('admin');
    }
}