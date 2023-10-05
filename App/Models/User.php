<?php 

namespace App\Models;


use App\Resources\Db;

class User extends Model
{
    protected const TABLE = 'users';
    
    /*
     * Function registration new user
     * @return true
     * */

    public function registration($post) 
    {
        //var_dump($post);die();
        $login = $this->cleanData($post['reg_login']);
        $password = trim($post['reg_password']);
        $conf_pass = trim($post['reg_password_confirm']);
        $email = $this->cleanData($post['reg_email']);
        $name = $this->cleanData($post['reg_name']);
        
        $msg = '';
        
        if (empty($login)) {
            $msg .= "Введите логин <br />";
        }
        if (empty($password)) {
            $msg .= "Введите пароль <br />";
        }
        if (empty($email)) {
            $msg .= "Введите адрес почтового ящика <br />";
        }
        if (empty($name)) {
            $msg .= "Введите имя <br />";
        }
        
        if ($msg) {
            $_SESSION['reg']['login'] = $login;
            $_SESSION['reg']['email'] = $email;
            $_SESSION['reg']['name'] = $name;
            return $msg;
        }
        
        if ($conf_pass == $password) {
            $db = Db::getInstance();            
            $sql = "SELECT user_id FROM "
                . static::TABLE . " WHERE login=:login";
            $data = [':login' => $login];
            $rows = $db->countRow($sql, $data);
            
            if ($rows > 0) {
                $_SESSION['reg']['email'] = $email;
                $_SESSION['reg']['name'] = $name;
                
                return 'Пользователь с таким логином уже существует!!!';
            }
            
            
            $password = password_hash($password, PASSWORD_DEFAULT);
            $hash = md5(microtime());            
            
            $query = "INSERT INTO " . static::TABLE . "
                     (login,password,email, name, hash)
                     VALUES
                     (:login, :password, :email, :name, :hash)";
            
            $data = [
                ':login' => $login,
                ':password' => $password,
                ':email' => $email,
                ':name' => $name,
                ':hash' => $hash,
            ];  
            
            
            $result2 = $db->run($query, $data);
            //var_dump($result2);die();
            if (!$result2) {
                $_SESSION['reg']['login'] = $login;
                $_SESSION['reg']['email'] = $login;
                $_SESSION['reg']['name'] = $login;
                return "Ошибка при добавлении пользователя в базу данных!!!";
            } else {
                $headers = '';
                $headers .= "From: Admin <admin@mail.ru \r\n";
                $headers .= "Content-Type: text/plan; charset=utf8";
                
                $tema = "registration";
                
                $mail_body =
                "Спасибо за регистрацию на сайте. Ваша ссылка для подтверждения  учетной записи: http://localhost:83/?ctrl=Confirm&hash=" . $hash;
                
                mail($email, $tema, $mail_body, $headers);
                
                return true;
            }
           
            
        } else {
            $_SESSION['reg']['login'] = $login;
            $_SESSION['reg']['email'] = $email;
            $_SESSION['reg']['name'] = $name;
            return 'Вы неправильно подтвердили пароль!!!';
        }
        
    }
    
    /*
     * Function confirm new user
     * @return true
     * */
    public function confirm() 
    {
        $db = Db::getInstance();
        $hash = $this->cleanData($_GET['hash']);
        $sql = "UPDATE " . static::TABLE . " SET confirm='1' WHERE hash=:hash";
        $data = [':hash' => $hash];
        $rows = $db->countRow($sql, $data);
        
        if ($rows == 1) {
            return true;
        } else {
            return 'Неверный код регистрации!!!';
        }
    }
    
    /*
     * Function check new user
     * @return true
     * */
    public function checkUser() 
    {
        $db = Db::getInstance();
        
        if (isset($_SESSION['sess'])) {
            $sess = $_SESSION['sess'];
            $sql = "SELECT user_id FROM " . static::TABLE . " WHERE sess=:sess";
            $data = [":sess" => $sess];
            $row = $db->countRow($sql, $data);
            
            if (!$row || $row < 1) {
                return false;
            }
            return true;
        } elseif (isset($_COOKIE['login']) && isset($_COOKIE['password'])) {
            $login = $_COOKIE['login'];;
            $password = $_COOKIE['password'];
            $sql = "SELECT user_id FROM " . static::TABLE . 
                   " WHERE login=:login
                     AND password=:password
                     AND confirm=1";
            $data = [':login' => $login, ':password' => $password];
            $row2 = $db->countRow($sql, $data);
            
            if (!$row2 || $row2 < 1) {
                return false;
            }
            
            $sess = md5(microtime());
            $sql_update = "UPDATE " . static::TABLE . 
                          " SET sess=:sess
                            WHERE login=:login";
            $data_update = [':sess' => $sess, ':login' => $login];
            $result = $db->run($sql_update, $data_update);
            
            if (!$result) {
                return 'Ошибка авторизации пользователя!!!';
            }
            
            $_SESSION['sess'] = $sess;
            
            return true;
        } else {
            return false;
        }
    }
    
    
    /*
     * Function check insert existing login and password
     * @return true
     * */
    public function login($post) 
    {
        if (empty($post['login']) || empty($post['password'])) {
            return 'Заполните поля входа!!!';
        }
        
        $login = $this->cleanData($post['login']);
        $userpass = trim($post['password']);
        
        $db = Db::getInstance();
        $sql = "SELECT password, confirm FROM " . static::TABLE .
        " WHERE login=:login";
        $data = [':login' => $login];
        $result = $db->query($sql, $data);
        $confirm =  (int)$result[0]['confirm'];
        $password = $result[0]['password'];
        
        if (!$result || !password_verify($userpass, $password)) {
           return 'Вы ввели нeсуществующий логин или пароль!!!';
        }
        if ($confirm == 0) {
            return 'Пользователь ещё не подтверждён!!!';
        }
        
        $sess = md5(microtime());
        
        $sql_update = "UPDATE " . static::TABLE . " SET sess=:sess WHERE login=:login";
        $value = [':sess' => $sess, ':login' => $login];
        $result2 = $db->run($sql_update, $value);
        
        if (!$result2) {
            return 'Ошибка авторизации пользователя!!!';
        }
        
        $_SESSION['sess'] = $sess;
        
        if ($post['member'] == 1) {
            $time = time() + 10 * 24 * 3600;
            
            setcookie('login', $login, $time);
            setcookie('password', $password, $time);
        }
        
        return true;
    }
    
    /*
     * Function create new password an send in insert existing email
     * @return true
     * */
    public function getPassword($email) 
    {
        $db = Db::getInstance();
        $email = $this->cleanData($email);
        $sql = "SELECT user_id FROM " . static::TABLE . " WHERE email=:email";
        $data = [':email' => $email];
        $row = $db->countRow($sql, $data);
        $column = $db->getColumn($sql, $data, 0);
        
        if (!$row) {
            return 'Невозможно сгенерировать новый пароль!!!';
        }
        
        if ($row == 1) {
            $str = '234567890qwertYuIopasdFGHjklZXcvbnM';
            $pass = '';
            
            for ($i = 0; $i < 10; $i++) {
                $x = mt_rand(0, (strlen($str) - 1));
                
                if ($i != 0) {
                    if (isset($pass[strlen($str) - 1]) == $str[$x]) {
                        $i--;
                        continue;;
                    }
                }                
                $pass .= $str[$x];
            }
            
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $sql_update = "UPDATE " . static::TABLE . 
                          " SET password=:hash WHERE user_id=:column";
            $data_update = [':hash' => $hash, ':column' => $column];
            $result = $db->run($sql_update, $data_update);
            
            if (!$result) {
                return 'Невозможно сгенерировать новый пароль!!!';
            }
            
            $headers = '';
            $headers .= "From Admin <admin@mail.ru> \r\n";
            $headers .= "Content-Type:text/plain;charset=utf8";
            $subject = 'new password';
            $mail_body = 'Ваш новый пароль: ' . $pass;
            var_dump('Ваш новый пароль: ' . $pass);die();
            mail($email, $subject, $mail_body, $headers);
            
            return true;
        } else {
            return 'Пользователя с таким почтовым ящиком не существует!!!';
        }
    }
}