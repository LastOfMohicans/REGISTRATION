<?php
namespace App\Traits;

trait Singleton
{
    private static $instance = null;
    
    public static function getInstance() 
    {
        if (null === static::$instance) {
            return static::$instance = new static;
        }
    }
}

