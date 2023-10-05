<?php 

namespace App\Models;

use App\Resources\Db;

abstract class Model
{
    protected const TABLE = '';
    
    /*
     * Function return all articles in database table
     * */

    public static function getStatti()
    {       
        $db = Db::getInstance();
        $sql = 'SELECT * FROM ' . static::TABLE;        
        $result = $db->query($sql, []);        

        if (!$result) {
            printf("Соединение не удалось: %s\n", $db->connect_error);
            exit();
        }

        $row = [];
        
        foreach ($result as $key => $value) {
            $row[$key] = $value;
        }

        return $row;
    }
    
    /*
     * @return clean insert data in inputs
     * */

    public function cleanData($str)
    {
        return strip_tags(trim($str));
    }
    
    /*
     * Function unset $_SESSION['sess']
     * Set cookies login and password 
     * @return true
     * */

    public function logout()
    {
        unset($_SESSION['sess']);
        setcookie('login', '', time() - 3600);
        setcookie('password', '', time() - 3600);

        return true;
    }
}