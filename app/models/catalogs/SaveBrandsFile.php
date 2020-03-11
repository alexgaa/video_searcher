<?php


namespace brands\app\models\catalogs;
use \brands\vendor\core\db\DB;
use \brands\vendor\core\file\FileWork;


class SaveBrandsFile {
     /**
     * Выгрузка всех брендов из базы в файл и выдача пользователю
     * @return boolean
     */
    public static function readAllBrands(){
        $db=DB::getDB(DB_BRANDS);
        $sql="SELECT TEMP.*, `User`.`user_name` as request_name FROM 
        (SELECT `Brand`.*, `User`.`user_name` as `check_name` FROM `Brand` INNER JOIN `User`  ON `Brand`.`id_responsible_check` =`User`.`id` ) as TEMP INNER JOIN
        `User` ON `TEMP`.`id_responsible_request` =`User`.`id` ";
        $result=$db->get($sql);
        //Добавляем названия столбцов
        $name_array_brands=require_once COLUM_NAME_BRANDS;
        array_unshift($result, $name_array_brands);
        //записываем данные в файл в формате CSV
        FileWork::csvWriteFile(NAME_FILE_USER, $result);
        $file1=DIR_TEMP.$_SESSION['dir_user'].'/'.NAME_FILE_USER;
        //выдача файла с данными пользователю
        if(!FileWork::fileUploadUser($file1)){
            return false;
        }
        return true;
    }
}
