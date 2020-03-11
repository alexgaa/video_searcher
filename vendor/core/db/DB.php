<?php
namespace brands\vendor\core\db;

/**
 * Description of BD
 *
 * @author aleksey.ga
 */




class DB{
    /**
    * обьект подключение к БД
    *
    */
    private static $_db;
    /**
    * обьект подключение к БД
    *
    */
    private $_link;
    /**
    * создаём подключение к БД
    *
    * @param string имя файла с настройкми БД
    *
    */
    private function __construct($namefile){
        if(!file_exists($namefile)){
            $full_text_error="Ошибка подключения к БД, ф-я: function __construct; ненайден файл с настройками:'".$namefile."'; тип ошибки ";
            log_my_error(1,$full_text_error,__FILE__,__LINE__);
            throw new \Exception('Настройки БД не найдены');
        }
        $config=require_once $namefile;    //"../config/db_config_brands.php";
        $this->_link = new \PDO($config['dsn'],$config['user'],$config['password']);
    }
    /**
    * пероверяет создано ли подключение к к БД
    *
    * @param string имя файла с настройкми БД
    * @return object возрашае линк на подключение к БД
    */
    public static function getDB($namefile){
        if(is_null(self::$_db)){
            self::$_db = new DB($namefile); // можно написать new self(); //				
        }
        return self::$_db;
    }
    /**
    * запись в БД(ISERT, UPDATE)
    *
    * @param string SQL запрос
    * @return Boolean возрашает true или false
    */    
    public function send($sql,$arr=[]){
        $send=$this->_link->prepare($sql);
        $error_e=$send->execute($arr);
        if(!$error_e){
           //echo "\nPDO::errorInfo():\n";
           //print_r($send->errorCode());
           return false;
        }
        
        return true;
    }
    /**
    * получение данных из БД(SELECT) подготовленным запросом
    *
    * @param string SQL запрос, array массив значение
    * @return array[][] возрашает 2х ассоц массив
    */    
    public function get($sql, $arr=[]){
        /* Выполнение запроса с передачей ему массива параметров */
        $send = $this->_link->prepare($sql);
        
        if(is_array($arr)){
            $send->execute($arr);
        }
        else{
            $send->execute();
        }
            $result = $send->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }
    
   
    
}
