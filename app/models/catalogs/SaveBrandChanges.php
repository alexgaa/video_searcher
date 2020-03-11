<?php
namespace brands\app\models\catalogs;
use \brands\vendor\core\db\DB;

/**
 * Сохранение изменений в брендах
 *
 * @author aleksey.ga
 */
class SaveBrandChanges {
    /**
     *
     * @var string расшифровка ошибки
     */
    public $error;
    /**
     * Удаление бренда из базы
     * @return boolean
     */
    public function delBrand(){
        if(!isset($_POST['array_js'])){
            $this->error=" Бренд не удалён. Ошибка данных!";
            return false;
        }
        $array_id=$_POST['array_js'];
        $data=[];
        $db=DB::getDB(DB_BRANDS);
        foreach ($array_id as $temp){
            $data['id_brand']=filter_var($temp,FILTER_VALIDATE_INT);
            if($data['id_brand']==""){
                $this->error=" Бренд не удалён. Ошибка данных!";
                return false;
            }
            $sql="DELETE FROM `Brand` WHERE id_brand=:id_brand";
            if(!$db->send($sql, $data)){
                $this->error=" Бренд не удалён. Ошибка записи БД!";
                return false;
            }
        }
        return true;
    }
    
    
    /**
     * Внесение изменений по брендам в базу
     * @return boolean 
     */
    public function savingChangesBrand(){
        if(!isset($_POST['array_js'])){
            $this->error=" Бренды не обновлены. Ошибка данных!";
            return false;
        }
        $array_id=$_POST['array_js'];
        $data=[];
        $db=DB::getDB(DB_BRANDS);
        $sql1="UPDATE `Brand` SET `brand_name`=:brand_name, id_carid=:id_carid, map=:map, file_update_period=:file_update_period,"
                    . "id_responsible_check=(SELECT `User`.`id` FROM `User` WHERE `User`.`user_name`=:id_responsible_check),"
                    . " id_responsible_request=(SELECT `User`.`id` FROM `User` WHERE `User`.`user_name`=:id_responsible_request)";
        $sql_end=" WHERE `id_brand`=:id_brand";
        
        foreach ($array_id as $temp){
            $data['id_brand']=filter_var($temp[0],FILTER_VALIDATE_INT);            
            $data['brand_name']=$temp[1];
            $data['id_carid']=$temp[2];
            $data['map']=$temp[3];
            $data['file_update_period']=$temp[4];
            $data['id_responsible_check']=$temp[5];
            $data['id_responsible_request']=$temp[6];
            $data['alternative_name1']=$temp[7];
            $data['alternative_name2']=$temp[8];
            $data['alternative_name3']=$temp[9];
            $data['alternative_name4']=$temp[10];
            $data['alternative_name5']=$temp[11];
            $data['vendor']=$temp[12];
            $data['comment_check']=$temp[13];
            $data['official_site']=$temp[14];
            $data['who_added']=$_SESSION['dir_user'];
            $data['date_edit']=date('Y-m-d');

            $sql2=", alternative_name1=:alternative_name1, alternative_name2=:alternative_name2, alternative_name3=:alternative_name3, alternative_name4=:alternative_name4"
                    . ", alternative_name5=:alternative_name5, vendor=:vendor, comment_check=:comment_check, official_site=:official_site, who_added=:who_added, date_edit=:date_edit ";

            $sql=$sql1.$sql2.$sql_end;
            if(!$db->send($sql, $data)){
                $this->error=" Бренд ".$data['brand_name']." не обновлён. Ошибка записи БД!";
                return false;
            }
        }
        return true;
    }
}
