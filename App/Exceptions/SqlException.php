<?php
namespace App\Exceptions;

use Throwable;

class SqlException extends \Exception
{
    protected $query;
    
    public function __construct(
        $query,
        $message = '',
        $code = 0,
        Throwable $previous = null,
        $sql = ''
        )
    {
        $this->query = $query;
        parent::__construct($message, $code, $previous);
    }
    
    public function getQuery()
    {
        return $this->query;
    }
}

