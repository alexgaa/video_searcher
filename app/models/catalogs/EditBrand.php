<?php

namespace brands\app\models\catalogs;
use \brands\vendor\core\db\DB;

/**
 * Description of EditBrand
 *
 * @author aleksey.ga
 */
class EditBrand {
     /**
     * Поиск брендов базе по названию или ID CarID
     * входящие данные из $_POST
     * @return boolean/array в случае успеха возращает массив значений если нет то false 
     */
    public static function searchBrand(){
        $arr=[];
        $sql="";
        // формируем запрос для выборки данных из связаных таблиц
        $sql1="SELECT TEMP.*, `User`.`user_name` as request_name FROM 
        (SELECT `Brand`.*, `User`.`user_name` as `check_name` FROM `Brand` INNER JOIN `User`  ON `Brand`.`id_responsible_check` =`User`.`id` WHERE  ";
        $sql4=") as TEMP
        INNER JOIN
        `User` ON `TEMP`.`id_responsible_request` =`User`.`id`";
        //    
        $name_brand=filter_input(INPUT_POST, 'name_brand');
        $id_carid=filter_input(INPUT_POST, 'id_carid');
        // если в друг название и ID оказались пуустыми то выход    
        if($name_brand=="" AND $id_carid==""){
            return false;
        }
        
        if($name_brand!=""){
            $arr['brand_name']=$name_brand;
            $sql2="`brand_name` LIKE '%".$arr['brand_name']."%'";
        }
        else {
            $sql2="";
        }
        
        if($id_carid!=""){
            $arr['id_carid']=$id_carid;
            $sql3="`id_carid` LIKE '%".$arr['id_carid']."%'";
        }
        else {
            $sql3="";
        }
        // формируем по однуму полю или двум сразу
        if($sql2!="" AND $sql3!="" ){
            $sql=$sql1.$sql2." OR ".$sql3.$sql4;
        }
        else{
            $sql=$sql1.$sql2.$sql3.$sql4;
        }
       // return $sql;
        
        $db=DB::getDB(DB_BRANDS);
        $result=$db->get($sql, $arr);
        if($result!=""){
            return $result;
        }
        else {
            return false;
        }
    }
}
