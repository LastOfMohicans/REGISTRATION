<?php
namespace App\Controllers;

abstract class Error extends Controller
{
    protected $ex;

    public function __construct(\Exception $ex)
    {
        parent::__construct();
        $this->ex = $ex;
    }
}

