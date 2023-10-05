<?php 

namespace App\Models;

class Article extends Model
{
    protected const TABLE = 'statti';

    /*
     * @return all articles in databse in table statti
     * */
    public static function getAllArticles()
    {
        return static::getStatti();
    }

    
}