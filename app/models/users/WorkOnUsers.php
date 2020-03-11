<?php
namespace brands\app\models\users;
use \brands\vendor\core\db\DB;

/**
 * Работа с настроками пользователей
 *
 * @author aleksey.ga
 */
class WorkOnUsers
{
    /**
    * 
    * проверка пользовател и пароля БД
    * 
    * @return boolean массив
    */
    public function get($usersName=[])
    {
        $db= DB::getDb(DB_SEARCH_VIDEO);;
        //ищем пользователя в БД
        $sql3=" ORDER BY user_name";
        if(is_array($usersName)){
            $sql="SELECT * FROM User";
            $sql=$sql.$sql3;
            $result=$db->get($sql);
        }
        else{
            $sql="SELECT * FROM User WHERE user_name = :user_name";
            $sql=$sql.$sql3;
        }
        return $result;
    }
}
