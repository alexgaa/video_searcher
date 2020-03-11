<?php
namespace brands\app\models\users;
use \brands\vendor\core\db\DB;
use \brands\vendor\core\file\FileWork;
use \brands\vendor\core\check\DataArray;


/**
 * Добавление/обновление пользователей из загруженного файла
 *
 * @author aleksey.ga
 */
class UsersReadFile
{
    
    /**
     * названия стобцов для проверки в файле
     */
    public $nameColum=['username'=>'User name',
         'pass'=>'Pass',
         'fullname'=>'Full name',
         'typeuser'=>'Type user',
         'tl'=>'Tl',
         'block'=>'Block',
         'type'=>'Type',
         'admin'=>'Admin',
         'inven'=>'Inven',
         'check'=>'Check',
         'vendor'=>'Vendor',
         'tl_imp'=>'TL_Imp',
         'imp'=>'Imp',
         'mand'=>'Mand',
         'all'=>'All'];
    /**
     *  текст ошибки если она есть, если ошибкт нет то false
     * @var string
     */
    public $error=false;
    /**
     * Чтение данных из файла и 
     * @param string $nameFile - название файла
     * @return boolean false - если нет ошибок, true - если ошибки (текст ошибки $error)
     */
    public function addUsers($nameFile)
    {
        $user_file= new FileWork;
        $array_users=$user_file->аrrayDataFromCsvFile($nameFile);//получаем 2х мерный массив с данными
        if($array_users){
            $columNumber=$user_file->checkColumArray($this->nameColum,$array_users); //масив названий с номером столбца или false если столбец не неайден
            if($columNumber){
                if($this->userAddBase($array_users, $columNumber)){
                    return true;
                }
                else{
                    return false;
                }
            }
            else{
                $this->error=$user_file->error;
                return false;
            }
        }
        else{
            $this->error=$user_file->error;
            return false;
        }
    }
    /**
     * 
     * @param array $array_users - массив с данными пользователей
     * @param array $columNumber - массив номеров столбцов
     * @return boolean если найдены ошибки то false(текст ошибки $error), если все Ок то true
     */
    public function userAddBase($array_users,$columNumber)
    {
        $db= DB::getDb(DB_SEARCH_VIDEO);;
        array_shift($array_users); // удаляем названия столбцов
      
        //    Проверяем данные на дубликаты пользователей
        if(!DataArray::checkDuplicate($array_users,$columNumber, 'username')){ 
            $this->error=DataArray::$error;
            return false;
        }

        //добавляем данные в базу
        $sql1="REPLACE INTO User (`user_name`, `pass`,`fullname`, `typeuser`,`tl` ,`block`, `type`, `admin_t`, `inventory_t`, `check_t`, `vendor_t`, `tl_import_t`, `import_t`, `manager_t`, `all_t`)";
        foreach ($array_users as $user){
            $username=addslashes($user[$columNumber['username']]);
            $pass=password_hash($user[$columNumber['pass']],PASSWORD_DEFAULT);
            $fullname=addslashes($user[$columNumber['fullname']]);
            $typeuser=addslashes($user[$columNumber['typeuser']]);
            $tl=addslashes($user[$columNumber['tl']]);
            $block=addslashes($user[$columNumber['block']]);
            $type=addslashes($user[$columNumber['type']]);
            $admin=addslashes($user[$columNumber['admin']]);
            $inven=addslashes($user[$columNumber['inven']]);
            $check=addslashes($user[$columNumber['check']]);
            $vendor=addslashes($user[$columNumber['vendor']]);
            $tl_imp=addslashes($user[$columNumber['tl_imp']]);
            $imp=addslashes($user[$columNumber['imp']]);
            $mand=addslashes($user[$columNumber['mand']]);
            $all=addslashes($user[$columNumber['all']]);
            $sql2=" VALUES ('".$username."','".$pass."','".$fullname."','".$typeuser."','".$tl."','".$block."','".$type."','".$admin."','".$inven."','".$check
                ."','".$vendor."','".$tl_imp."','".$imp."','".$mand."','".$all."')";
            $sql=$sql1.$sql2;
            if(!$db->send($sql)){
                $this->error="<b style='color:#ff0000'> Ошибка!</b> Загрузка остановленна! Проблема с загрузкой данныйх по пользователю: ".$username;
                return false;
            }
        }
        return true;
    }
}