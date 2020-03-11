<?php
namespace brands\app\controller;

Use \brands\vendor\core\file\FileWork;
use \brands\app\models\result\SaveResult;
use \brands\app\models\db\DbWork;
use \brands\app\models\general\StartSearch;

/**
 * Контроллер main
 *
 * @author aleksey.ga
 */
class MainController extends App
{
    public function index()
    {
        $result="";
        $arr=compact ('result'); 
        $this->set ($arr);
    }
    /**
     * Получение входящих данный от пользоватея и их обработка
     */
    public function linkUser()
    {   
        $result="";
        if (isset($_POST['linkUser'])){ //получаем линк для поиска видео
            $arr=StartSearch::lexani(); //поиск видео на сайте Lexani
            $this->set($arr);
        } else{
            $this->view='index';
            $arr=compact('result'); 
            $this->set ($arr);
        }
    }
    
    /**
     * выдача файла с результатом 
     */
    public function fileResult(){
        $nameFile=DIR_TEMP.$_SESSION['dir_user'].'/'.NAME_FILE_RESULT;
        if(!FileWork::fileUploadUser($nameFile)){
            $result=ERROR_TEXT."Нет файла для выгрузки.";
            $this->view='index';
            $arr=compact('result'); 
            $this->set ($arr);
        }
    }
    /**
     * выдача файла с сравнением линков 
     */
    public function fileComparison(){
        $nameFile=DIR_TEMP.$_SESSION['dir_user'].'/'.NAME_FILE_COMPARISON;
        if(!FileWork::fileUploadUser($nameFile)){
            $result=ERROR_TEXT."Нет файла для выгрузки.";
            $this->view='index';
            $arr=compact('result'); 
            $this->set ($arr);
        }
    }
    /**
     * выдача файла с ошибками 
     */
    public function fileError(){
        $nameFile=DIR_TEMP.$_SESSION['dir_user'].'/'.NAME_FILE_LINK_ERROR;
        if(!FileWork::fileUploadUser($nameFile)){
            $result=ERROR_TEXT."Нет файла для выгрузки.";
            $this->view='index';
            $arr=compact('result'); 
            $this->set ($arr);
        }
    }
    
    /**
     * Выводим все записи из базы линков в таблицу
     */
    public function read()
    {
        $data_array=DbWork::selectAllData(); //получаем данные из базы
        $arrKeyDel=[0=>'id', 1=>'id_input_url']; // столбцы для удаления из массива данных
        $data_array=SaveResult::delColumn($data_array,$arrKeyDel); //удаляем лишние столбцы
        SaveResult::saveResultFile($data_array, NAME_FILE_RESULT, COLUM_NAME_RESULT_FULL);// сохраняем в файл
        $arr=compact('data_array'); //упаковываем данные в массив
        $this->set($arr);
    }
    
    /**
     * удаляем записи из БД
     */
    public function delete()
    {
        $data_array=false;
        if(isset($_POST['array_js'])){ //получены данные на удаление
           $idArray=$_POST['array_js'];
           if(DbWork::deleteArrayVideo($idArray)){//удаляем данные из базы
               echo "Записи успешно удалены.";
               $this->layout=false;// отключение шаблона, для обработки Ajax запроса
           } else{
              echo "Ошибка удаления."; 
           }
        } else {
            $data_array=DbWork::selectAllData(); //получаем данные из базы
            $arr=compact('data_array'); 
            $this->set($arr);
        }
    }
   
    
}
