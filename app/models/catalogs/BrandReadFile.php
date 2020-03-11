<?php
namespace brands\app\models\catalogs;
use \brands\vendor\core\db\DB;
use \brands\vendor\core\file\FileWork;
use \brands\vendor\core\check\DataArray;
/**
 * Description of BrandReadFile
 *
 * @author aleksey.ga
 */
class BrandReadFile {
    /**
     * названия стобцов для проверки в файле
     */
    public $nameColum=['brand_name'=>'Brand name',
        'id_carid'=>'Id Carid',
        'map'=>'Map',
        'file_update_period'=>'File Update Period',
        'status'=>'Status',
        'id_responsible_check'=>'Responsible Check',
        'id_responsible_request'=>'Responsible Request',
        'alternative_name1'=>'Alternative name1',
        'alternative_name2'=>'Alternative name2',
        'alternative_name3'=>'Alternative name3',
        'alternative_name4'=>'Alternative name4',
        'alternative_name5'=>'Alternative name5',
        'vendor'=>'Vendor',
        'comment_check'=>'Comment Check',
        'official_site'=>'Official Site',
         ];
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
    public function addBrand($nameFile){
        $brand_file= new FileWork;
        $array_brands=$brand_file->аrrayDataFromCsvFile($nameFile);//получаем 2х мерный массив с данными
        if($array_brands){
            $columNumber=$brand_file->checkColumArray($this->nameColum,$array_brands); //масив названий с номером столбца или false если столбец не неайден
            if($columNumber){
                if($this->brandAddBase($array_brands, $columNumber)){
                    return true;
                }
                else{
                    return false;                   
                }
            }
            else{
                $this->error=$brand_file->error;
                return false;
            }
        }
        else{
            $this->error=$brand_file->error;
            return false;
        }
    }
    /**
     * 
     * @param array $array_brands - массив с данными пользователей
     * @param array $columNumber - массив номеров столбцов
     * @return boolean если найдены ошибки то false(текст ошибки $error), если все Ок то true
     */
    public function brandAddBase($array_brands,$columNumber){
        $db= DB::getDb(DB_BRANDS);
        array_shift($array_brands); // удаляем названия столбцов
        //Проверяем данные на дублика названий брендов
        if(!DataArray::checkDuplicate($array_brands,$columNumber, 'brand_name')){ //TEMP_ID_CARID
            $this->error=DataArray::$error;
            return false;
        }
        //Проверяем данные на дубликаты ID Carid  для брендов
        if(!DataArray::checkDuplicate($array_brands,$columNumber, 'id_carid',TEMP_ID_CARID)){ 
            $this->error=DataArray::$error;
            return false;
        }
        //добавляем данные в базу
        $sql1="REPLACE INTO Brand (`brand_name`, `id_carid`, `map`, `file_update_period`, `status`,`id_responsible_check`, `id_responsible_request`,"
                . " `alternative_name1`, `alternative_name2`, `alternative_name3`, `alternative_name4`, `alternative_name5`, `vendor`, `comment_check`,"
                . " `official_site`, `date_added`, `date_edit`, `who_added`)";
        $data=[];
        foreach ($array_brands as $brand){
            $data['brand_name']=$brand[$columNumber['brand_name']];
            $data['id_carid']=$brand[$columNumber['id_carid']];
            $data['map']=$brand[$columNumber['map']];
            $data['file_update_period']=$brand[$columNumber['file_update_period']];
            $data['status']=$brand[$columNumber['status']];
            $data['id_responsible_check']=$brand[$columNumber['id_responsible_check']];
            $data['id_responsible_request']=$brand[$columNumber['id_responsible_request']];
            $data['alternative_name1']=$brand[$columNumber['alternative_name1']];
            $data['alternative_name2']=$brand[$columNumber['alternative_name2']];
            $data['alternative_name3']=$brand[$columNumber['alternative_name3']];
            $data['alternative_name4']=$brand[$columNumber['alternative_name4']];
            $data['alternative_name5']=$brand[$columNumber['alternative_name5']];
            $data['vendor']=$brand[$columNumber['vendor']];
            $data['comment_check']=$brand[$columNumber['comment_check']];
            $data['official_site']=$brand[$columNumber['official_site']];
            $data['date_added']=date('Y-m-d');
            $data['date_edit']=date('Y-m-d');
            $data['who_added']=$_SESSION['dir_user'];
           
           
            $sql2=" VALUES (:brand_name, :id_carid, :map, :file_update_period, :status , (SELECT `User`.`id` FROM `User` WHERE `User`.`user_name`=:id_responsible_check),"
                    . " (SELECT `User`.`id` FROM `User` WHERE `User`.`user_name`=:id_responsible_request),"
                . " :alternative_name1, :alternative_name2, :alternative_name3, :alternative_name4, :alternative_name5, :vendor, :comment_check,"
                . " :official_site, :date_added, :date_edit, :who_added)";
            $sql=$sql1.$sql2;
            if(!$db->send($sql, $data)){
                $this->error="<b style='color:#ff0000'> Ошибка!</b> Загрузка остановленна! Проблема с загрузкой данныйх по бренду: ".$brand_name;
                return false;
            }
        }
        return true;
    }
    
}
