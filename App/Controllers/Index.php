<?php 

namespace App\Controllers;

use App\Models\Article;

class Index extends Controller
{
    protected function handle()
    {
        session_start();
        header('Content-Type:text/html;charset=utf8');

        $this->view->posts = Article::getAllArticles();
        $this->view->display('index');
        
    }
}