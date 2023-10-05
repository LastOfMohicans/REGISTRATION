<?php
namespace App\Resources;

use App\Traits\Singleton;
use PDO;
use App\Exceptions\DbConnectEx;
use App\Exceptions\SqlException;

class Db
{
    use Singleton;
    private $dbh;
    
    /*
     * Connection in database
     * */

    public function __construct()
    {
        try {
            require 'config.php';
            $this->dbh = new PDO(DSN, USER, PASSWORD);
        } catch (\Exception $ex) {
            throw new DbConnectEx('Ошибка подключения к БД!!!', 2);
        }        
    }
    
    /*
     * Execute SQL query
     * @return $res
     * */
    
    public function run(string $sql, array $data) 
    {
        $sth = $this->dbh->prepare($sql);
        $res = $sth->execute($data);
        return $res;
    }
    
    /*
     * Execute SQL query 
     * @return count row
     * */
    
    public function countRow($sql, $data) 
    {
        $sth = $this->dbh->prepare($sql);
        $sth->execute($data);
        $res = $sth->rowCount();
        return $res;
    }
    
    /*
     * Execute SQL query
     * @return num column
     * */
    
    public function getColumn(string $sql, array $data = [], int $column = null) 
    {
        $sth = $this->dbh->prepare($sql);
        $sth->execute($data);
        $res = $sth->fetchColumn($column);
        return $res;
    }
    
    /*
     * Execute query 
     * @returns an array indexed by column name as returned in your result set
     * */
    
    public function query(string $sql, array $data = []) 
    {
        try {
            $sth = $this->dbh->prepare($sql);
            $sth->execute($data);
            $res = $sth->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        } catch (\Exception $ex) {
            throw new SqlException($sql, 'Ошибка SQL запроса!!!', 1);
        }
    }
}

