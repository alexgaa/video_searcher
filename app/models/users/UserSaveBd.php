<?php
namespace brands\app\models\users;
use \brands\vendor\core\db\DB;


class UserSaveBd
{
    public $error;
    
    /**
     * Получение данных из Ajax и перенаправлени на обработчик в зависимости от type
     * Входящие данные POST
     * @return boolean
     */
    public function analysis()
    {
        $array_js=$_POST['array_js'];
        $name_table=$_POST['name_table'];
        $type=$_POST['type'];
        if($name_table!=''){
            if($type=="edit_user"){
                if(!UserSaveBd::analysisUserSave($array_js, $name_table)){
                    $this->error="Ошибка записи в BD";
                    return false; 
                }
            }
            if($type=="edit_pass"){
                if(!UserSaveBd::analysisPass($array_js, $name_table)){
                    $this->error="Ошибка записи в BD";
                    return false; 
                }
            }
            if($type=="edit_del"){
                if(!UserSaveBd::analysisDel($array_js, $name_table)){
                    $this->error="Ошибка записи в BD";
                    return false; 
                }
            }
            return true;
        }
        else{
            $this->error="Ошибка записи в BD";
            return false; 
        }
    }
    
    
    /**
     * Обновление в БД пароля пользователя
     * @param array $array_js массив данных
     * @param string $name_table названия таблицы
     */
    public  static function analysisPass($array_js, $name_table)
    {
        $data=[];
        $db=DB::getDb(DB_SEARCH_VIDEO);
        $sql1="UPDATE ".$name_table." SET ";
        foreach ($array_js as $temp){
            $data['id']=addslashes($temp[0]);
            $data['pass']=password_hash($temp[1],PASSWORD_DEFAULT);
            $sql2="pass=:pass WHERE id=:id";
            $sql=$sql1.$sql2;
            if(!$db->send($sql,$data)){
                return false;
            };
        }
        return true;
    }
    
    /**
     * Удаление пользователя из БД
     * @param array $array_js массив данных
     * @param string $name_table названия таблицы
     */
    public  static function analysisDel($array_js, $name_table)
    {
        $data=[];
        $db=DB::getDb(DB_SEARCH_VIDEO);
        $sql1="DELETE FROM ".$name_table." WHERE ";
        foreach ($array_js as $temp){
            $data['id']=addslashes($temp[0]);
            $sql2="id=:id";
            $sql=$sql1.$sql2;
            if(!$db->send($sql,$data)){
               return false; 
            };    
        }
        return true;
    }
    /**
     * Обноавление в БД данных по пользователям
     * @param array $array_js массив данных
     * @param string $name_table названия таблицы
     */
    public static function analysisUserSave($array_js, $name_table)
    {
        $data=[];
        $db=DB::getDb(DB_SEARCH_VIDEO);
        $sql1="UPDATE ".$name_table." SET ";
        foreach ($array_js as $temp){
            $data['id']=addslashes($temp[0]);
            $data['username']=addslashes($temp[1]);
            $data['fullname']=addslashes($temp[2]);
            $data['typeuser']=addslashes($temp[3]);
            $data['tl']=addslashes($temp[4]);
            $data['block']=addslashes($temp[5]);
            if($data['block']==""){$data['block']=0;}
            $data['type']=addslashes($temp[6]);
            $data['admin']=addslashes($temp[7]);
            $data['inven']=addslashes($temp[8]);
            $data['check']=addslashes($temp[9]);
            $data['vendor']=addslashes($temp[10]);
            $data['tl_imp']=addslashes($temp[11]);
            $data['imp']=addslashes($temp[12]);
            $data['mand']=addslashes($temp[13]);
            $data['all']=addslashes($temp[14]);
            $sql2="user_name=:username, fullname=:fullname, typeuser=:typeuser, tl=:tl, block=:block, type=:type, admin_t=:admin, inventory_t=:inven, "
                   . "check_t=:check, vendor_t=:vendor, tl_import_t=:tl_imp, import_t=:imp, manager_t=:mand, all_t=:all WHERE id=:id";
             
            $sql=$sql1.$sql2;
            if(!$db->send($sql,$data)){
                return false;
            }
        } 
        return true;
    }
}