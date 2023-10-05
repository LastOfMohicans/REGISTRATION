<?php
namespace App\Controllers;

use App\Exceptions\SqlException;
use App\Resources\Logger;

class SqlError extends Error
{

    public function __construct(SqlException $ex)
    {
        parent::__construct($ex);
    }
    
    protected function handle()
    {
        Logger::writeLog($this->ex);
        $message = $this->ex->getMessage();
        $query = $this->ex->getQuery;
        $this->view->message = $message;
        $this->view->query = $query;
        $this->view->display('exceptions/sqlerror');
    }

}

