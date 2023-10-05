<?php
namespace App\Controllers;

use App\Exceptions\DbConnectEx;
use App\Resources\Logger;

class DbError extends Error
{

    public function __construct(DbConnectEx $ex)
    {
        parent::__construct($ex);
    }
    
    protected function handle()
    {
        Logger::writeLog($this->ex);
        $message = $this->ex->getMessage();
        $code = $this->ex->getCode();
        $this->view->message = $message;
        $this->view->code = $code;
        $this->view->display('exceptions/dbconnecterror');
    }

    
    
}

