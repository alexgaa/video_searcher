<?php

namespace brands\app\models\catalogs;
use \brands\app\models\users\SearchUser;
use \brands\vendor\core\db\DB;
/**
 * Добавление нового бренда в справочник брендов
 *
 * @author aleksey.ga
 */
class NewBrand {
    /**
     *
     * @var string текст ошибки
     */
    public $error='';



    /**
     * Добавление нового бренда в базу справочников
     * @return boolean возращает true если успешно добавлен и false в случае ошибки
     */
    public function newBrnadAdd(){
        $brand=New NewBrand();
        $result=$brand->checkBrandData();
        if(!$result){
            $this->error=$brand->error;
            return false;
        }
        return true;
    }
    /**
     * Проверка бренда и добавление в базу
     * @return boolean
     */
    private function checkBrandData(){
        $data=[]; 
        // -----Подготовка и проверка данных перед заптсью ----------------------------------------------------------------------------------
        //----- обязательные к заполнению данные по бренду -----------------------------------------------------------------------------------
        $data['brand_name']= filter_input(INPUT_POST, 'brandname');
        //$data['brand_name']= addslashes(filter_input(INPUT_POST, 'brandname'));
        $data['id_carid']= filter_input(INPUT_POST, 'id_сarid', \FILTER_SANITIZE_NUMBER_INT);
        $data['map']= filter_input(INPUT_POST, 'map');
        $data['file_update_period']= filter_input(INPUT_POST, 'file_update_period');
        $data['status']= addslashes(filter_input(INPUT_POST, 'status'));
        /*проверка responsible на наличие в базе user*/
        $responsible_temp= filter_input(INPUT_POST, 'id_responsible_check');
        $data['id_responsible_check']= SearchUser::checkInBd($responsible_temp);
        if(!$data['id_responsible_check']){
            $this->error=ERROR_TEXT." Бренд не добавлен, пользователь: ".$responsible_temp." не найден!";
            return false;
        }
         /*проверка responsible на наличие в базе user*/
        $responsible_temp=filter_input(INPUT_POST, 'id_responsible_request');
        $data['id_responsible_request']= SearchUser::checkInBd($responsible_temp);
        if(!$data['id_responsible_request']){
            $this->error=ERROR_TEXT." Бренд не добавлен, пользователь: ".$responsible_temp." не найден!";
            return false;
        }
        // проверка на пустоту обязательных полей
        if($data['brand_name']=="" or $data['map']=="" or $data['file_update_period']=="" or $data['status']=="" or $data['id_responsible_check']=="" or $data['id_responsible_request']==""){
            $this->error=ERROR_TEXT." Бренд не добавлен, не заполнен обязательный параметр.";
            return false;
        }
        //если бренд на заведён на CarId то ставим временный ID
        if($data['id_carid']==""){
            $data['id_carid']=TEMP_ID_CARID;    
        }          
         //проверяем есть ли название бренда в базе   
        $valid_sataus=$this->checkBrandName($data['brand_name']);
        if($valid_sataus){
            $this->error=ERROR_TEXT." Бренд не добавлен, т.к. бренд: ".$data['brand_name']." уже есть в базе!";
            return false;
        }
        // проверяем на уникальность ID CarID для нового бренда
        $valid_sataus=$this->checkBrandIdCarId($data['id_carid']);
        if($valid_sataus){
            $this->error=ERROR_TEXT." Бренд не добавлен, т.к. c ID CarID=".$data['id_carid']." в базе числится бренд: '".$valid_sataus."' !";
            return false;
        }
        
        // идинтифицируем создателя бренда и дату создания
        $data['date_added']=date('Y-m-d');
        $data['date_edit']=date('Y-m-d');
        $data['who_added']=$_SESSION['dir_user'];
        
        //------ Дополнительные (не обязательные) к заполнению данные по бренду---------------------------------------
        $data['alternative_name1']=filter_input(INPUT_POST,'alternative_name1');
        $data['alternative_name2']=filter_input(INPUT_POST,'alternative_name2');
        $data['alternative_name3']=filter_input(INPUT_POST,'alternative_name3');
        $data['alternative_name4']=filter_input(INPUT_POST,'alternative_name4');
        $data['alternative_name5']=filter_input(INPUT_POST,'alternative_name5');
        $data['vendor']=filter_input(INPUT_POST,'vendor');
        $data['comment_check']=filter_input(INPUT_POST,'comment_check');
        $data['official_site']=filter_input(INPUT_POST,'official_site');
        //-- добавление  всех данных в базу
        $db1=DB::getDB(DB_BRANDS);
        $sql1="INSERT INTO Brand (`brand_name`, `id_carid`, `file_update_period`,`map`, `status`, `id_responsible_check`,`id_responsible_request`, `date_added`, `who_added`, `date_edit`, "
                . "`alternative_name1`, `alternative_name2`, `alternative_name3`, `alternative_name4`, `alternative_name5`, `vendor`, `comment_check`, `official_site`)";
        $sql2=" VALUES (:brand_name, :id_carid, :file_update_period, :map, :status, :id_responsible_check, :id_responsible_request, :date_added, :who_added, :date_edit, :alternative_name1, :alternative_name2, :alternative_name3,"
                . ":alternative_name4, :alternative_name5, :vendor, :comment_check, :official_site)";
        $sql=$sql1.$sql2;
        if(!$db1->send($sql, $data)){
            $this->error=ERROR_TEXT." Бренд не добавлен. Ошибка записи БД!";
            return false;
        }
        return true;
    }
    
    /**
     * Проверяет есть ли бренд в базе
     * @param string $value искомый бренд
     * @return string/boolean возращает id бренда или false если не найден
     */
    private function checkBrandName($value){
        $sql="SELECT * FROM Brand WHERE brand_name=:brand_name";
        $data['brand_name'] =$value;
        $db=DB::getDB(DB_BRANDS);
        $result=$db->get($sql, $data);
        if(isset($result[0]['id_brand'])){
            return $result[0]['id_brand'];
        }
        else {
            return false;
        }
    }
    
    /**
     * Проверяет есть ли ID_CARID в базе
     * @param string $value искомый бренд
     * @return string/boolean возращает id бренда или false если не найден
     */
    private function checkBrandIdCarId($value){
        if($value==TEMP_ID_CARID){
            return false;
        }
        $sql="SELECT * FROM Brand WHERE id_carid=:id_carid";
        $data['id_carid'] =$value;
        $db=DB::getDB(DB_BRANDS);
        $result=$db->get($sql, $data);
        if(isset($result[0]['brand_name'])){
            return $result[0]['brand_name'];
        }
        else {
            return false;
        }
    }
}
