<?php
namespace brands\app\models;
use \brands\vendor\core\db\DB;

/**
 * Проверка существования пользователя и пароля
 *
 */
class CheckUser {
    private static $user;
    private static $pass;
    public static $error="<p class='error'><b>Ошибка пароля или логина!</b></p>";
    /**
     * 
     * проверка пользователя и пароля
     * @param string $user логин пользователя
     * @param string $pass пароль пользователя
     * 
     * @return boolean (в $error описание ошибки);
    */
    public static function check($user='', $pass=''){
        if($user!='' ){
            if($pass!=''){
                self::$user=$user;
                self::$pass=$pass;
                return self::checkDbUser(); // проверка пользователя и пароля
            }
            else {
                return false;
            }
        }
        else{
            return false;
        }
    }
     /**
     * 
     * проверка пользовател и пароля БД
     * 
     * @return boolean/ array
     */
    private static function checkDbUser(){
        $db= DB::getDb(DB_SEARCH_VIDEO);
        //ищем пользователя в БД
        $sql="SELECT * FROM User WHERE user_name = :user_name";
        $result=$db->get($sql,array(':user_name' => self::$user));
        if($result[0]['id']!=''){
            if($result[0]['block']>5){
                // сработал счётчик блокировки записи (6 неудачных попыток ввода пароля)
                self::$error="<p class='error'><b>Учётная запись заблокированна!</b></p>";
                return false;
            }
            //if(self::$pass==$result[0]['pass']){ //сверяем пароль без хеша
            if(password_verify(self::$pass,$result[0]['pass'])){ //сверяем пароль
                self::$error="<p class='error'><b>Ok</b></p>";
               // сброс счётчика блокировки записи
               $sql="UPDATE User SET block=:block WHERE id =:id";
               $block=Null;
               $send=$db->send($sql, array(':block' => $block,':id'=>$result[0]['id']));
               return $result;
            }
            else{
                // включение счётчика блокировки записи
                $sql="UPDATE User SET block=:block WHERE id =:id";
                $block=$result[0]['block']+1;
                $send=$db->send($sql, array(':block' => $block,':id'=>$result[0]['id']));
                return false;
            }
        }
    }
    /**
     * 
     * @param string $access парамерт доступа
     * @return boolean|string если доступ на чтение то false
     */
    public static function checkAccess($access){
        switch ($access){
            case "w": return "w";
            case "W": return "w";
            case "a": return "a";    
            case "A": return "a";    
            default: return false;
        }
    }
    /**
     * Делает список пользователей из базы по запрошенному параметру (типу)
     * @param string $sql2 параметры для поиска: пример "type='Check'"
     * @return boolean/array возвращает массив пользователей
     */
    public static function listUsersStatus($sql2){
        $db=DB::getDb(DB_SEARCH_VIDEO);
        $user=[];
        if($sql2==""){
            return false;
        }
        $sql="SELECT * FROM User WHERE ".$sql2;
        $result_temp=$db->get($sql);
        if($result_temp){
            foreach ($result_temp as $temp){
                $user[]=$temp['user_name'];
            }
            return $user;
        }
        return false;
    }
    
}
