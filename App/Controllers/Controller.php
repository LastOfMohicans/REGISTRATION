<?php 

namespace App\Controllers;

use App\View\View;

abstract class Controller
{
    protected $view;
    abstract protected function handle();

    public function __construct()
    {
        $this->view = new View();
    }

    protected function access() : bool
    {
        return true;
    }

    public function __invoke()
    {
        if ($this->access()) {
            $this->handle();
        } else {
            die('Нет доступа!!!');
        }
    }
}