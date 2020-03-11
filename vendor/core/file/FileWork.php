<?php
namespace brands\vendor\core\file;

/**
 * Description of FileWork
 *
 * @author aleksey.ga
 */

class FileWork{
    public $error;
    /**
     * Обработка загруки файла
     * @param type $dir_name - каталог куда сохранять, 
     * @param type $username - префик к каталогу для сохранения (обычно логин пользователя )
     * @param type $namefile - имя для сохранения
     * @return string - возвращает путь на сохраннённый файл
     */
    public function fileSave($dir_name, $username="", $namefile='uploadfile'){
         if(!empty($_FILES)){
            if($_FILES[$namefile]['tmp_name']==''){
                return NULL;
            }
            $uploaddir =$dir_name.$username.'/';
            if(!file_exists($uploaddir)){
                    mkdir($uploaddir);
            }
            $uploadfile = $uploaddir.basename($_FILES[$namefile]['name']);
            // Копируем файл из каталога для временного хранения файлов:
            if (move_uploaded_file($_FILES[$namefile]['tmp_name'], $uploadfile))
            {
                //echo '<br>A2';    
                return $uploadfile;
            }
            else { 
                //echo '<br>A3';
                return NULL;
            }
        }
        else {
            // echo '<br>A4';
            return NULL;
        }
    }
        
    /**
     * Description обработка загрузки нескольких файлов одноврменно
     * @param type $dir_name - каталог куда сохранять, 
     * @param type $username - префик к каталогу для сохранения (обычно логин пользователя )
     * @param type $namefile - имя для сохранения
     * @param type $file_name_user - имя загружаемого файла
     * @return возвращает путь на сохраннённый файл
     */
    public function fileSaveArray($dir_name, $username="",$namefile='uploadfile', $file_name_user){
        if(!empty($_FILES)){
            if($_FILES[$namefile]['tmp_name'][0]==''){
                echo 'Выберите файл!<BR>';
                return NULL;
            }
            $quantity_files=count($_FILES[$namefile]['name']);
            $i=0;
            for($i; $i<$quantity_files; $i++){
                if($file_name_user==$_FILES[$namefile]['name'][$i]){
                    break;
                }
            }
            if($i==$quantity_files){
                echo "Файл ".$file_name_user." - не был загружен. <br>";
                return NULL;
            }
            $uploaddir =$dir_name.$username.'/';
            if(!file_exists($uploaddir)){
                mkdir($uploaddir);
            }
            $uploadfile = $uploaddir.basename($_FILES[$namefile]['name'][$i]);
            // Копируем файл из каталога для временного хранения файлов:
            if (move_uploaded_file($_FILES[$namefile]['tmp_name'][$i], $uploadfile))
            {
                return $uploadfile;
            }
            else { 
                return NULL;
            }
        }
        else {
            return NULL;
        }
    }
    /**
     * Удаляёт файл
     * @param type $uploadfile путь к файлу
     */
    public function FileDel($uploadfile){
            unlink($uploadfile);
    }
    /**
     * Раззархивация zip файла
     * @param type $zip_file - имя файла
     * @param type $catalog_save - путь куда сохранять
     */
    public function ExtractionZipFile($zip_file, $catalog_save){
                $zip = new \ZipArchive(); //Создаём объект для работы с ZIP-архивами
                //Открываем архив archive.zip и делаем проверку успешности открытия
                if ($zip->open($zip_file) === true) {
                        $zip->extractTo($catalog_save); //Извлекаем файлы в указанную директорию
                        $zip->close(); //Завершаем работу с архивом
                }
                else echo "Архива не существует!"; //Выводим уведомление об ошибке
    }
    
    function __destruct() {
    }
    
    
    public $Max_colum=1;
    public $Max_string;
    public $arr = array();
    
    /**
     * считываение CSV файла в массив
     * @param type $file_name - имя файла
     * @param type $separator - разделитель
     * @return array - возращает двумерный массив со значениями
     * @throws \Exception
     */
    public function CsvReadFile($file_name,$separator='|'){
        $i=0;
        $file= new \SplFileObject($file_name);
        $file->setFlags(\SplFileObject::SKIP_EMPTY);
        $max_string_arr=0;
        foreach ($file as $row) {
            if($row[0]!=="|"){
                $arra_t=explode($separator,$row);
                $this->arr[$i]=$arra_t;
                if($i==0){
                    $max_string_arr=count($arra_t);
                }
                if($max_string_arr!=count($arra_t)){  // отлавливаем спец символ
                    unlink($file_name);
                    $this->error="<b style='color:#ff0000'> Ошибка!</b> В файле <b>'".substr(strrchr($file_name,'/'),1)."'</b> ! Строка ".$i." содержит спец символ | или перенос строки(ctrl+j), данные не загруженны, удалите/замените в файле все символы | и переносы строки в ячейке(ctrl+j) !";
                    return false;
                }
                $i++;
            }
            else {
                 $this->error='<b style="color:#ff0000"> Ошибка!</b> Входящий файл содержал пустую строку!</b>';
            }
        }
        $this->Max_colum=count($this->arr[0]);
        $this->Max_string=count($this->arr);
        if($this->Max_string<=1 and $this->Max_colum<=1){
            unlink($file_name);
            $this->error="<b style='color:#ff0000'> Ошибка!</b> Файл ".substr(strrchr($file_name,'/'),1)." - пустой!!!";
            return false;
        }
        unlink($file_name);
        return $this->arr;
    }
    
    /**
     * Поиск столбца по названию
     * @param type $array_temp
     * @param type $name_colum
     * @return int
     */
    public static function searchСolumName($array_temp,$name_colum){
        $i=0;
        foreach ($array_temp[0] as $colum){
            if (strcmp(strtolower(rtrim(ltrim($colum))),strtolower(rtrim(ltrim($name_colum))))==0){
                return $i;
            }
            $i++; 
        }
        $i=false;
        return $i;
    }
    
     /**
     *  читает данные из CSV файла и сохранняет в 2х мерный массив
     * @param string $nameFile
     * @return array / false возращает массив 
     */
    public function  аrrayDataFromCsvFile($nameFile){
        $user_file= new FileWork;    
        $full_name_file=$user_file->fileSave(DIR_TEMP,$_SESSION['dir_user'],$nameFile); // получаем путь к файлу
        if($full_name_file){
            $array_users=$user_file->CsvReadFile($full_name_file); //читаем файл CSV в массив
            if($array_users===false){
                $this->error=$user_file->error;
            }
            else{ // получили массив данных из файла
                return $array_users;
            }
                return false;
        }
        else{
            $this->error='Ошибка загрузки файла';
        } 
        return false;
    }
    /**
     * определяем где находятся нужные столбцы, если столбец не найдет возращаем ошибку 
     * @param array $nameColum - назване искомых столбцов
     * @param array $array_users - массив для поиска столбцов
     * результат  с номерами столбцов
     * @return array / false массив номеров столбцов(текст ошибки $this->error)
    */
    public function checkColumArray($nameColum,$array_users){
        if($array_users===false){
            return false;
        }
        $columNumber=[];
        $keyName=array_keys($nameColum); //получаем все ключи 
        $i=0;
        foreach ($nameColum as $name){
            $number=FileWork::searchСolumName($array_users,$name); // получаем номер столбца или fallse если не найден
            if($number===false){
                $this->error="<b style='color:#ff0000'> Ошибка!</b>  Не найден столбец: <b>".$name."</b> - загрузка отменена!";
                return false;
            }
            else{
                $columNumber[$keyName[$i]]=$number; // присваиваем названию стобца номер колонки из файла
            }              
            $i++;
        }
        return $columNumber;
    }
    
    
    /**
     * 
     * @param string $name_file имя файла
     * @param type $arr массив данных для записис
     * @param type $separator разделитель по умолчанию |
     */
    public static function csvWriteFile($name_file,$arr,$separator='|'){
        $a="";
        $tempdir =DIR_TEMP.$_SESSION['dir_user'].'/';
        if(!file_exists($tempdir)){
            mkdir($tempdir);
        }
        $name_file=$tempdir.$name_file;
        $file= new \SplFileObject($name_file,'w');
        foreach ($arr as $fields) {
            $a=implode($separator,$fields)."\n";
            $file->fwrite($a);
        }
    }
    
    /**
     * выдаём файл с данными
     * @return boolean
     */
    public static function fileUploadUser($file){
        if (file_exists($file)) {
            // сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
            // если этого не сделать файл будет читаться в память полностью!
            if (ob_get_level()) {
              ob_end_clean();
            }
            // заставляем браузер показать окно сохранения файла
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            // читаем файл и отправляем его пользователю
            if (readfile($file)){
                return true;
            } else {
                return false;
            }
            
        }
        else{
            return false;
        }
    }
            
   
}
